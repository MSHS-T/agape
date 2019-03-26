<?php

namespace App\Http\Controllers;

use App\ProjectCall;
use App\Setting;

use App\Enums\CallType;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $projectcalls = ProjectCall::withTrashed()->with('creator')->get();
        return view('projectcall.index', compact('projectcalls'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projectcall.edit', [
            'mode'        => 'create',
            'method'      => 'POST',
            'action'      => route('projectcall.store'),
            'projectcall' => (object)[
                'type'                   => 1,
                'year'                   => intval(date('Y'))+1,
                'title'                  => '',
                'description'            => '',
                'application_start_date' => '',
                'application_end_date'   => '',
                'evaluation_start_date'  => '',
                'evaluation_end_date'    => '',
                'number_of_experts'      => Setting::get('default_number_of_experts'),
                'number_of_documents'    => Setting::get('default_number_of_documents'),
                'number_of_keywords'     => Setting::get('default_number_of_keywords'),
                'number_of_laboratories' => Setting::get('default_number_of_laboratories'),
                'number_of_study_fields' => Setting::get('default_number_of_study_fields'),
                'number_of_target_dates' => Setting::get('default_number_of_target_dates'),
                'privacy_clause'         => '',
                'invite_email_fr'        => '',
                'invite_email_en'        => '',
                'help_experts'           => '',
                'help_candidates'        => ''
            ]
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
            'type'                   => ['required', 'integer', new EnumValue(CallType::class, false)],
            'year'                   => 'required|integer|min:'.(intval(date('Y')) - 1),
            'title'                  => 'required',
            'description'            => 'required',
            'application_start_date' => 'required|date',
            'application_end_date'   => 'required|date|after:application_start_date',
            'evaluation_start_date'  => 'required|date|after:application_end_date',
            'evaluation_end_date'    => 'required|date|after:evaluation_start_date',
            'number_of_experts'      => 'required|integer|min:1',
            'number_of_documents'    => 'required|integer|min:0',
            'number_of_keywords'     => 'required|integer|min:0',
            'number_of_laboratories' => 'required|integer|min:0',
            'number_of_study_fields' => 'required|integer|min:0',
            // Optional fields
            // 'number_of_target_dates' => '',
            // 'privacy_clause' => '',
            // 'invite_email_fr' => '',
            // 'invite_email_en' => '',
            // 'help_experts' => '',
            // 'help_candidates' => ''
        ]);

        $call = new ProjectCall($request->all());
        $call->save();

        return redirect()->route('projectcall.index')
                         ->with('success', __('actions.projectcall.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  ProjectCall  $projectcall
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectCall $projectcall)
    {
        return view('projectcall.show', compact('projectcall'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ProjectCall  $projectcall
     * @return \Illuminate\Http\Response
     */
    public function edit(ProjectCall $projectcall)
    {
        return view('projectcall.edit', [
            'mode'        => 'edit',
            'method'      => 'PUT',
            'action'      => route('projectcall.update', $projectcall),
            'projectcall' => $projectcall
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  ProjectCall  $projectcall
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProjectCall $projectcall)
    {
        $request->validate([
            'type'                   => ['required', 'integer', new EnumValue(CallType::class, false)],
            'year'                   => 'required|integer|min:'.(intval(date('Y')) - 1),
            'description'            => 'required',
            'application_start_date' => 'required|date',
            'application_end_date'   => 'required|date|after:application_start_date',
            'evaluation_start_date'  => 'required|date|after:application_end_date',
            'evaluation_end_date'    => 'required|date|after:evaluation_start_date',
            'number_of_experts'      => 'required|integer|min:1',
            'number_of_documents'    => 'required|integer|min:0',
            'number_of_keywords'     => 'required|integer|min:0',
            'number_of_laboratories' => 'required|integer|min:0',
            'number_of_study_fields' => 'required|integer|min:0',
            // Optional fields
            // 'number_of_target_dates' => '',
            // 'privacy_clause' => '',
            // 'invite_email_fr' => '',
            // 'invite_email_en' => '',
            // 'help_experts' => '',
            // 'help_candidates' => ''
        ]);

        $updatedData = $request->only([
            'title', 'description', 'application_start_date', 'application_end_date', 'evaluation_start_date', 'evaluation_end_date', 'number_of_experts', 'number_of_documents', 'number_of_keywords', 'number_of_laboratories', 'number_of_study_fields', 'number_of_target_dates', 'privacy_clause', 'invite_email_fr', 'invite_email_en', 'help_experts', 'help_candidates'
        ]);

        $projectcall->fill($updatedData);
        $projectcall->save();
        return redirect()->route('projectcall.index')
                         ->with('success', __('actions.projectcall.edited'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ProjectCall  $projectcall
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProjectCall $projectcall)
    {
        $projectcall->delete();
        return redirect()->route('projectcall.index')
                         ->with('success', __('actions.projectcall.deleted'));
    }

    /**
     * Creates an application for the given project call
     *
     * @param  ProjectCall  $projectcall
     * @return \Illuminate\Http\Response
     */
    public function apply(ProjectCall $projectcall)
    {
        $application = $projectcall->applications()
                                   ->firstOrNew([
                                       'applicant_id' => Auth::id(),
                                       'keywords' => '[]'
                                    ]);
        $application->save();
        return redirect()->route('application.edit', $application);
    }

    /**
     * Lists applications for the given project call
     *
     * @param  ProjectCall  $projectcall
     * @return \Illuminate\Http\Response
     */
    public function applications(ProjectCall $projectcall)
    {
        $projectcall->load(['applications', 'applications.applicant']);
        $applications = $projectcall->submittedApplications()->get();
        return view('application.index', compact('projectcall', 'applications'));
    }
}
