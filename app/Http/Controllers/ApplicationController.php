<?php

namespace App\Http\Controllers;

use App\Application;
use App\Laboratory;
use App\Person;
use App\Setting;
use App\StudyField;
use App\Enums\CallType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function edit(Application $application)
    {
        $carriers = Person::where('is_workshop', $application->projectcall->type == CallType::Workshop)->get();
        $laboratories = Laboratory::all();
        $study_fields = StudyField::all();
        $application->laboratories()->orderBy('order', 'asc')->get();
        return view('application.edit', compact('application', 'carriers', 'laboratories', 'study_fields'));
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
        $simple_fields = ['title', 'acronym', 'duration', 'target_date', 'theme', 'summary_fr', 'summary_en', 'short_description', 'amount_requested', 'other_fundings', 'total_expected_income', 'total_expected_outcome'];
        $defaults = ['duration' => null, 'target_date' => null, 'theme' => null];
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
        $application->carrier()->dissociate();
        if(is_numeric($data->carrier_id)){
            $application->carrier()->associate(Person::find($data->carrier_id));
        } else if($data->carrier_id == "new"){
            $carrier_fields = ['last_name', 'first_name', 'status', 'email', 'phone'];
            $carrier_data = array_combine(
                $carrier_fields,
                array_map(function($f) use ($data) {
                    return $data->{"carrier_$f"};
                }, $carrier_fields)
            );
            $carrier = new Person($carrier_data);
            $carrier->save();
            $application->carrier()->associate($carrier);
        }

        //Laboratories
        $application->laboratories()->detach();
        foreach(range(1, Setting::get('max_number_of_laboratories')) as $iteration){
            $lab_id = $data->{'laboratory_id_'.$iteration};
            if($lab_id === "none") {
                continue;
            } else if(is_numeric($lab_id)) {
                $application->laboratories()->attach(Laboratory::find($lab_id), ['order' => $iteration]);
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
                $application->laboratories()->attach($lab, ['order' => $iteration]);
            }
        }

        //Study fields
        $application->studyFields()->detach();
        foreach(range(1, Setting::get('max_number_of_study_fields')) as $iteration){
            if(is_numeric($data->{"study_field_".$iteration})){
                dump($data->{"study_field_".$iteration});
                $sf = StudyField::find($data->{"study_field_".$iteration});
                $application->studyFields()->attach($sf);
            }
        }

        //Keywords
        $keywords = [];
        foreach(range(1, Setting::get('max_number_of_keywords')) as $iteration){
            if(!is_null($data->{'keyword_'.$iteration})){
                $keywords[] = $data->{'keyword_'.$iteration};
            }
        }
        $application->keywords = $keywords;

        // Files
        // Later

        $application->save();
        // return redirect()->route('home')->with('success', __('actions.application.saved'));
    }

    /**
     * Update a field of the the specified resource in storage storage.
     *
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function submit(Application $application)
    {

    }
}
