<?php

namespace App\Http\Controllers;

use App\Application;
use App\Laboratory;
use App\Person;
use App\StudyField;
use App\Enums\CallType;
use Illuminate\Http\Request;

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
        //
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
