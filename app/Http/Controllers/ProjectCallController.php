<?php

namespace App\Http\Controllers;

use App\ProjectCall;
use App\Setting;

use App\Enums\CallType;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use BenSampo\Enum\Rules\EnumValue;

class ProjectCallController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projectcalls = ProjectCall::with('creator')->get();
        return view('projectcall.index', compact('projectcalls'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projectcall.create', [
            'max_number_of_experts' => Setting::get('max_number_of_experts'),
            'max_number_of_documents' => Setting::get('max_number_of_documents'),
            'types' => CallType::toArray()
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
        $request->validate([
            'type' => ['required', 'integer', new EnumValue(CallType::class, false),
                        Rule::unique('project_calls')->where(function ($query) use ($request) {
                            return $query
                                ->where('type', $request->type)
                                ->where('year', $request->year);
                        })],
            'year' => 'required|integer|min:'.date('Y'),
            'description' => 'required',
            'application_start_date' => 'required|date',
            'application_end_date' => 'required|date|after:application_start_date',
            'evaluation_start_date' => 'required|date|after:application_end_date',
            'evaluation_end_date' => 'required|date|after:evaluation_start_date',
            'number_of_experts' => 'required|integer|min:1|max:'.Setting::get('max_number_of_experts'),
            'number_of_documents' => 'required|integer|min:0|max:'.Setting::get('max_number_of_documents'),
            // Optional fields
            // 'privacy_clause' => '',
            // 'invite_email_fr' => '',
            // 'invite_email_en' => '',
            // 'help_experts' => '',
            // 'help_candidates' => ''
        ],[
            'type.unique' => __('validation.custom.unique_type_year', ['type' => CallType::getKey($request->type), 'year' => $request->year])
        ]);

        $call = new ProjectCall($request->all());
        $call->save();

        return redirect()->route('projectcall.index')->with('success', __('actions.projectcall.created'));
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
