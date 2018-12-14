<?php

namespace App\Http\Controllers;

use App\ProjectCall;
use App\Setting;

use Illuminate\Http\Request;

class ProjectCallController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projectcall.create', [
            'max_number_of_experts' => Setting::find('max_number_of_documents'),
            'max_number_of_documents' => Setting::find('max_number_of_documents'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProjectCall  $projectCall
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectCall $projectCall)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProjectCall  $projectCall
     * @return \Illuminate\Http\Response
     */
    public function edit(ProjectCall $projectCall)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProjectCall  $projectCall
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProjectCall $projectCall)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProjectCall  $projectCall
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProjectCall $projectCall)
    {
        //
    }
}
