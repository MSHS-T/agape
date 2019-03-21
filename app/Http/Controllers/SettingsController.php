<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $settings = Setting::all();

        return view('settings', [
            'settings' => $settings
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        $request->validate([
            'max_number_of_target_dates' => 'required|gt:0',
            'max_number_of_experts'      => 'required|gt:0',
            'max_number_of_documents'    => 'required|gt:0',
            'max_number_of_laboratories' => 'required|gt:0',
            'max_number_of_study_fields' => 'required|gt:0',
            'max_number_of_keywords'     => 'required|gt:0',
            'notation_1_title' => 'required|string',
            'notation_2_title' => 'required|string',
            'notation_3_title' => 'required|string',
            'notation_1_description' => 'required|string',
            'notation_2_description' => 'required|string',
            'notation_3_description' => 'required|string',
            'extensions_application_form' => 'required|string',
            'extensions_financial_form' => 'required|string',
            'extensions_other_attachments' => 'required|string',
            'notation_grid_0_grade' => 'required|string',
            'notation_grid_0_details' => 'required|string',
            'notation_grid_1_grade' => 'required|string',
            'notation_grid_1_details' => 'required|string',
            'notation_grid_2_grade' => 'required|string',
            'notation_grid_2_details' => 'required|string',
            'notation_grid_3_grade' => 'required|string',
            'notation_grid_3_details' => 'required|string',
        ]);

        $data = $request->only([
            'max_number_of_target_dates', 'max_number_of_experts', 'max_number_of_documents', 'max_number_of_laboratories',
            'max_number_of_study_fields', 'max_number_of_keywords', 'notation_1_title', 'notation_2_title',
            'notation_3_title', 'notation_1_description', 'notation_2_description', 'notation_3_description',
            'extensions_application_form', 'extensions_financial_form', 'extensions_other_attachments'
        ]);
        foreach($data as $key => $value){
            Setting::set($key, $value);
        }

        $notation_grid = [];
        foreach(range(0,3) as $i){
            $notation_grid[$i] = [
                "grade" => $request->input("notation_grid_{$i}_grade"),
                "details" => $request->input("notation_grid_{$i}_details")
            ];
        }
        Setting::set('notation_grid', json_encode($notation_grid));
        return redirect()->route('settings')->with('success', __('actions.settings.saved'));
    }

}
