<?php

namespace App\Http\Controllers;

use App\Application;
use App\ApplicationFile;
use App\EvaluationOffer;
use App\Laboratory;
use App\Person;
use App\Setting;
use App\StudyField;
use App\User;
use App\Enums\CallType;
use App\Notifications\ApplicationSubmitted;
use App\Notifications\NewApplicationSubmitted;
use App\Notifications\OfferCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function show(Application $application)
    {
        // Don't display non-submitted applications
        if($application->submitted_at == null){
            abort(404);
        }
        return view('application.show', compact('application'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function edit(Application $application)
    {
        if(!empty($application->submitted_at)){
            return redirect()->route('home');
        }
        $laboratories = Laboratory::accessible()->get();
        $study_fields = StudyField::all();
        $application->laboratories()->orderBy('order', 'asc')->get();
        return view('application.edit', compact('application', 'laboratories', 'study_fields'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Application $application)
    {
        $data = (object) $request->all();

        //Simple fields with no post-treatment or validation at this time
        $simple_fields = ['title', 'acronym', 'duration', 'theme', 'summary_fr', 'summary_en', 'short_description', 'amount_requested', 'other_fundings', 'total_expected_income', 'total_expected_outcome'];
        $defaults = ['duration' => null, 'target_date' => [], 'theme' => null];
        $simple_data = array_merge(
            $defaults,
            array_combine($simple_fields,
                array_map(
                    function($f) use ($data){
                        return $data->{$f} ?? null;
                    },
                    $simple_fields
                )
            )
        );
        $application->fill($simple_data);

        //Carrier
        $carrier_fields = ['last_name', 'first_name', 'status', 'email', 'phone'];
        $carrier_data = array_combine(
            $carrier_fields,
            array_map(function($f) use ($data) {
                return $data->{"carrier_$f"};
            }, $carrier_fields)
        );
        $carrier_data['is_workshop'] = $application->projectcall->type == CallType::Workshop;
        $carrier = $application->carrier;
        $carrier->fill($carrier_data);
        $carrier->save();
        $application->carrier()->associate($carrier);

        //Laboratories
        $application->laboratories()->detach();
        foreach(range(1, Setting::get('max_number_of_laboratories')) as $iteration){
            $lab_id = $data->{'laboratory_id_'.$iteration};
            $lab_contact = $data->{'laboratory_contact_name_'.$iteration};
            if($lab_id === "none") {
                continue;
            } else if(is_numeric($lab_id)) {
                $application->laboratories()->attach(
                    Laboratory::find($lab_id),
                    [
                        'contact_name' => $lab_contact,
                        'order' => $iteration
                    ]
                );
            } else if($lab_id === "new") {
                $lab_fields = ['name', 'unit_code', 'director_email', 'regency'];
                $lab_data = array_combine(
                    $lab_fields,
                    array_map(function($f) use ($data, $iteration) {
                        return $data->{"laboratory_".$f."_".$iteration};
                    }, $lab_fields)
                );
                $lab = new Laboratory($lab_data);
                $lab->save();
                $application->laboratories()->attach($lab, [
                    'contact_name' => $lab_contact,
                    'order' => $iteration
                ]);
            }
        }

        //Study fields
        $application->studyFields()->detach();
        if(isset($data->study_fields)){
            foreach($data->study_fields as $sfValue){
                if(is_numeric($sfValue)){
                    $sf = StudyField::find($sfValue);
                } else {
                    $sf = new StudyField([
                        'name' => $sfValue
                    ]);
                    $sf->save();
                }
                $application->studyFields()->attach($sf);
            }
        }

        //Target dates
        $target_dates = [];
        foreach(range(1, Setting::get('max_number_of_target_dates')) as $iteration){
            $target_dates[] = $data->{"target_date_".$iteration} ?? null;
        }
        $application->target_date = array_filter($target_dates);

        //Keywords
        $keywords = [];
        foreach(range(1, Setting::get('max_number_of_keywords')) as $iteration){
            if(!is_null($data->{'keyword_'.$iteration})){
                $keywords[] = $data->{'keyword_'.$iteration};
            }
        }
        $application->keywords = $keywords;

        // Files
        // Replace only if a file has been sent
        $specific_files = ['application_form' => 1, 'financial_form' => 2];
        foreach($specific_files as $form_name => $order){
            if($request->hasFile($form_name)
            && ($rFile = $request->file($form_name))->isValid()
                && in_array(
                    $rFile->getClientOriginalExtension(),
                    array_map(
                        function($e){ return trim($e, '.'); },
                        explode(',', Setting::get("extensions_$form_name"))
                    )
                )
            ){
                $existingFile = $application->files()->where('order', $order)->delete();
                $name = $rFile->getClientOriginalName();
                $extension = $rFile->getClientOriginalExtension();
                $uniqname = str_random(40).'.'.$extension;
                $path = Storage::disk('public')->putFileAs('uploads', $rFile, $uniqname);
                $application->files()->create([
                    'order' => $order,
                    'name' => $name,
                    'filepath' => $path
                ]);
            }
        }
        $order = max(array_values($specific_files));
        if($request->hasFile('other_attachments')){
            $existingFiles = $application->files()
                                         ->whereNotIn('order', array_values($specific_files))
                                         ->delete();
            foreach($request->file('other_attachments') as $rFile){
                if(!$rFile->isValid()
                || !in_array(
                        $rFile->getClientOriginalExtension(),
                        array_map(
                            function($e){ return trim($e, '.'); },
                            explode(',', Setting::get("extensions_other_attachments"))
                        )
                    )
                ){
                    continue;
                }
                $name = $rFile->getClientOriginalName();
                $extension = $rFile->getClientOriginalExtension();
                $uniqname = str_random(40).'.'.$extension;
                $path = Storage::disk('public')->putFileAs('uploads', $rFile, $uniqname);
                $application->files()->create([
                    'order' => ++$order,
                    'name' => $name,
                    'filepath' => $path
                ]);
            }
        }

        $application->save();
        return redirect()->route('application.edit', ["application" => $application->id])
                         ->with('success', __('actions.application.saved'));
    }

    /**
     * Update a field of the the specified resource in storage storage.
     *
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function submit($id)
    {
        $application = Application::findOrFail($id);
        $data = $application->toArray();
        $validator = Validator::make($data, [
            'title'                             => 'required|max:255',
            'acronym'                           => 'required|max:15',
            'carrier_id'                        => 'required|exists:persons,id',
            'carrier.first_name'                => 'required|max:255',
            'carrier.last_name'                 => 'required|max:255',
            'carrier.email'                     => 'required|max:255|email',
            'carrier.phone'                     => 'required|max:255',
            'carrier.status'                    => 'required|max:255',
            'laboratories'                      => 'required',
            'laboratories.*.id'                 => 'required|exists:laboratories,id',
            'laboratories.*.name'               => 'required|max:255',
            'laboratories.*.unit_code'          => 'required|max:255',
            'laboratories.*.director_email'     => 'required|max:255|email',
            'laboratories.*.pivot.contact_name' => 'required|max:255',
            'laboratories.*.regency'            => 'required|max:255',
            'duration'                          => [
                function($attribute, $value, $fail) use ($application) {
                    if($application->projectcall->type != CallType::Workshop){
                        if(empty($value)){
                            $fail(__('validation.required_if', [
                            'attribute' => __('fields.application.duration'),
                            'other' => __('fields.projectcall.type'),
                            'value' => $application->projectcall->typeLabel,
                        ]));
                        }
                    }
                },
                'max:255'
            ],
            'target_date'                      => [
                function($attribute, $value, $fail) use ($application) {
                    if($application->projectcall->type == CallType::Workshop){
                        if(empty($value)){
                            $fail(__('validation.required_if', [
                            'attribute' => __('fields.application.target_date'),
                            'other' => __('fields.projectcall.type'),
                            'value' => $application->projectcall->typeLabel,
                        ]));
                        }
                    }
                }
            ],
            'target_date.*'                 => 'date',
            'study_fields'                  => 'required',
            'study_fields.*.id'             => 'required|exists:study_fields,id',
            'summary_fr'                    => 'required',
            'summary_en'                    => 'required',
            'keywords'                      => 'required|array|min:3',
            'keywords.*'                    => 'max:100',
            'short_description'             => 'required',
            'amount_requested'              => 'required|numeric|min:0',
            'other_fundings'                => 'required|numeric|min:0',
            'total_expected_income'         => 'required|numeric|min:0',
            'total_expected_outcome'        => 'required|numeric|min:0',
            'files'                         => [function($attribute, $value, $fail){
                $orders = array_column($value, 'order');
                if(!in_array(1, $orders)){
                    $fail(__('validation.required', [
                        'attribute' => __('fields.application.template.prefix.application')
                    ]));
                }
                if(!in_array(2, $orders)){
                    $fail(__('validation.required', [
                        'attribute' => __('fields.application.template.prefix.financial')
                    ]));
                }
            }],
            'files.*.id'    => 'required|exists:application_files,id',
            'files.*.order' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return redirect()
                        ->route('application.edit', ["application" => $application->id])
                        ->withErrors($validator)
                        ->withInput();
        }

        $application->submitted_at = \Carbon\Carbon::now();
        $application->save();

        // Notify admins
        Notification::send(User::admins()->get(), new NewApplicationSubmitted($application));
        $application->applicant->notify(new ApplicationSubmitted($application));

        return redirect()->route('home')
                         ->with('success', __('actions.application.submitted'));
    }

    /**
     * List assignations between experts and application
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function assignations($id)
    {
        $application = Application::with('projectcall', 'offers', 'offers.expert', 'offers.creator', 'offers.evaluation')->findOrFail($id);
        $assigned_experts = $application->offers()->get()->pluck('expert.id')->all();
        $experts = User::experts()->whereNotIn('id', $assigned_experts)->get();
        return view('application.assignations', compact('application', 'experts'));
    }

    /**
     * Assign an expert to an application
     *
     * @param  int  $application_id
     * @return \Illuminate\Http\Response
     */
    public function assign($application_id, Request $request)
    {
        $expert_id = $request->get('expert_id');
        $application = Application::with('offers', 'offers.expert')->findOrFail($application_id);
        $expert = User::findOrFail($expert_id);
        $offer = $application->offers()->firstOrNew(['expert_id' => $expert_id]);
        $offer->save();

        $expert->notify(new OfferCreated());

        return redirect()->route('application.assignations', ['id' => $application_id])
                         ->with('success', __('actions.application.expert_assigned'));
    }

    /**
     * Remove an assignation
     *
     * @param  int  $offer_id
     * @return \Illuminate\Http\Response
     */
    public function unassign($offer_id)
    {
        $offer = EvaluationOffer::findOrFail($offer_id);
        $application_id = $offer->application_id;
        $offer->delete();
        return redirect()->route('application.assignations', ['id' => $application_id])
                         ->with('success', __('actions.application.expert_unassigned'));
    }
}
