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
use App\Notifications\ApplicationUnsubmitted;
use App\Notifications\ApplicationForceSubmitted;
use App\Notifications\NewApplicationSubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApplicationController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function show(Application $application)
    {
        // Don't display non-submitted applications if user is not an admin
        if($application->submitted_at == null && !Auth::user()->isAdmin()){
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
            return redirect()->route('home')
                             ->withErrors([__('actions.application.already_submitted')]);
        }
        if(!$application->projectcall->canApply() && $application->devalidation_message == null){
            return redirect()->route('home')
                             ->withErrors([__('actions.projectcall.cannot_apply_anymore')]);
        }
        $laboratories = Laboratory::accessible()->get();
        $study_fields = StudyField::accessible()->get();
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
        if(!empty($application->submitted_at)){
            return redirect()->route('home')
                             ->withErrors([__('actions.application.already_submitted')]);
        }
        if(!$application->projectcall->canApply() && $application->devalidation_message == null){
            return redirect()->route('home')
                             ->withErrors([__('actions.projectcall.cannot_apply_anymore')]);
        }
        $data = (object) $request->all();

        //Simple fields with no post-treatment or validation at this time
        $simple_fields = ['title', 'acronym', 'other_laboratories', 'duration', 'theme', 'summary_fr', 'summary_en', 'short_description', 'amount_requested', 'other_fundings', 'total_expected_income', 'total_expected_outcome'];
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
        foreach(range(1, $application->projectcall->number_of_laboratories) as $iteration){
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
        foreach(range(1, $application->projectcall->number_of_target_dates) as $iteration){
            $target_dates[] = $data->{"target_date_".$iteration} ?? null;
        }
        $application->target_date = array_filter($target_dates);

        //Keywords
        $keywords = [];
        foreach(range(1, $application->projectcall->number_of_keywords) as $iteration){
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
                $uniqname = Str::random(40).'.'.$extension;
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
                $uniqname = Str::random(40).'.'.$extension;
                $path = Storage::disk('public')->putFileAs('uploads', $rFile, $uniqname);
                $application->files()->create([
                    'order' => ++$order,
                    'name' => $name,
                    'filepath' => $path
                ]);
            }
        }

        $application->save();
        return redirect()->route('application.edit', ["application" => $application])
                         ->with('success', __('actions.application.saved', ['reference' => $application->reference]));
    }

    /**
     * Update a field of the the specified resource in storage storage.
     *
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function submit(Application $application)
    {
        if(!empty($application->submitted_at)){
            return redirect()->route('home')
                             ->withErrors([__('actions.application.already_submitted', ['reference' => $application->reference])]);
        }
        if(!$application->projectcall->canApply() && $application->devalidation_message == null){
            return redirect()->route('home')
                             ->withErrors([__('actions.projectcall.cannot_apply_anymore')]);
        }
        $data = $application->toArray();
        $validator = Validator::make($data, [
            'title'                             => 'required|max:255',
            'acronym'                           => [
                function($attribute, $value, $fail) use ($application) {
                    if($application->projectcall->type != CallType::Workshop){
                        if(empty($value)){
                            $fail(__('validation.required_if', [
                            'attribute' => __('fields.application.acronym'),
                            'other' => __('fields.projectcall.type'),
                            'value' => $application->projectcall->typeLabel,
                        ]));
                        }
                    }
                },
                'max:15'
            ],
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
            'laboratories.*.pivot.contact_name' => [
                function($attribute, $value, $fail){
                    if(empty($value)){
                        $fail(__('validation.required', [
                            'attribute' => __('fields.laboratory.contact_name')
                        ]));
                    }
                }
            ],
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
            'files'                         => [function($attribute, $value, $fail) use ($application) {
                $orders = array_column($value, 'order');
                if(!in_array(1, $orders)){
                    $fail(__('validation.required', [
                        'attribute' => __('fields.application.template.prefix.application')
                    ]));
                }
                if(!empty($application->projectcall->financial_form_filepath) && !in_array(2, $orders)){
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
                        ->route('application.edit', ["application" => $application])
                        ->withErrors($validator)
                        ->withInput();
        }

        $application->submitted_at = \Carbon\Carbon::now();
        $application->save();

        // Notify admins
        Notification::send(User::admins()->get(), new NewApplicationSubmitted($application));
        $application->applicant->notify(new ApplicationSubmitted($application));

        return redirect()->route('home')
                         ->with('success', __('actions.application.submitted', ['reference' => $application->reference]));
    }

    /**
     * Forces application submission
     *
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function forceSubmit(Application $application)
    {
        if(!empty($application->submitted_at)){
            return redirect()->route('projectcall.applications', ['projectcall' => $application->projectcall])
                             ->withErrors([__('actions.application.already_submitted', ['reference' => $application->reference])]);
        }

        $application->submitted_at = \Carbon\Carbon::now();
        $application->save();

        // Notify applicant
        $application->applicant->notify(new ApplicationForceSubmitted($application));

        return redirect()->route('projectcall.applications', ['projectcall' => $application->projectcall])
                         ->with('success', __('actions.application.force_submitted', ['reference' => $application->reference]));
    }

    /**
     * Un-submit application
     *
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function unsubmit(Application $application, Request $request)
    {
        $application->submitted_at = null;
        $application->devalidation_message = $request->input('justification');
        $application->save();

        // Notify applicant
        $application->applicant->notify(new ApplicationUnsubmitted($application));

        return redirect()->route('projectcall.applications', ['projectcall' => $application->projectcall])
                         ->with('success', __('actions.application.unsubmitted', ['reference' => $application->reference]));
    }

    /**
     * List assignations between experts and application
     *
     * @param  Application  $application
     * @return \Illuminate\Http\Response
     */
    public function assignations(Application $application)
    {
        $application->load(['projectcall', 'offers', 'offers.expert', 'offers.creator', 'offers.evaluation']);
        $assigned_experts = $application->offers()->get()->pluck('expert.id')->all();
        $experts = User::experts()->whereNotIn('id', $assigned_experts)->get();
        return view('application.assignations', compact('application', 'experts'));
    }
}
