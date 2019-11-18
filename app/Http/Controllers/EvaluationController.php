<?php

namespace App\Http\Controllers;

use App\Application;
use App\Evaluation;
use App\EvaluationOffer;
use App\ProjectCall;
use App\User;
use App\Notifications\EvaluationSubmitted;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

use PDF;

class EvaluationController extends Controller
{
    /**
     * Display the evaluations for a specific projectcall.
     *
     * @param  ProjectCall $projectcall
     * @return \Illuminate\Http\Response
     */
    public function indexForProjectCall(ProjectCall $projectcall)
    {
        $evaluations = collect([]);
        foreach($projectcall->submittedApplications as $application){
            $evaluations = $evaluations->merge($application->evaluations);
        }
        return view('evaluation.index', compact('evaluations', 'projectcall'));
    }

    /**
     * Display the evaluations for a specific application.
     *
     * @param  Application  $application
     * @return \Illuminate\Http\Response
     */
    public function indexForApplication(Application $application)
    {
        $evaluations = $application->evaluations;
        return view('evaluation.index', compact('evaluations', 'application'));
    }

    /**
     * Export the evaluations for a specific projectcall.
     *
     * @param  ProjectCall $projectcall
     * @return \Illuminate\Http\Response
     */
    public function exportForProjectCall(ProjectCall $projectcall, Request $request)
    {
        $evaluations = collect([]);
        foreach($projectcall->submittedApplications as $application){
            $evaluations = $evaluations->merge($application->evaluations);
        }
        $evaluations = $evaluations->reject(function($e){ return is_null($e->submitted_at); });
        $anonymized = boolval($request->input('anonymized', "0"));

        $title = implode(' - ', [config('app.name'), __('actions.evaluation.export_name'), __('vocabulary.calltype_short.'.$projectcall->typeLabel), $projectcall->year]);

        $pdf = PDF::loadView('export.evaluations', compact('evaluations', 'projectcall', 'anonymized'));
        return $pdf->download($title . '.pdf');
    }

    /**
     * Export the evaluations for a specific application.
     *
     * @param  Application  $application
     * @return \Illuminate\Http\Response
     */
    public function exportForApplication(Application $application, Request $request)
    {
        $evaluations = $application->evaluations;
        $evaluations = $evaluations->reject(function($e){ return is_null($e->submitted_at); });
        $projectcall = $application->projectcall;
        $anonymized = boolval($request->input('anonymized', "0"));

        $title = implode(' - ', [config('app.name'), __('actions.evaluation.export_name'), __('vocabulary.calltype_short.'.$projectcall->typeLabel), $projectcall->year]);

        $pdf = PDF::loadView('export.evaluations', compact('evaluations', 'projectcall', 'anonymized'));
        return $pdf->download($title . '.pdf');
    }

    /**
     * Display the specified resource.
     *
     * @param  Evaluation  $evaluation
     * @return \Illuminate\Http\Response
     */
    public function show(Evaluation $evaluation)
    {
        return view('evaluation.show', compact('evaluation'));
    }

    /**
     * Show the form for the evaluation.
     *
     * @param  Evaluation  $evaluation
     * @return \Illuminate\Http\Response
     */
    public function edit(Evaluation $evaluation)
    {
        if(!empty($evaluation->submitted_at)){
            return redirect()->route('home')
                             ->withErrors([__('actions.evaluation.already_submitted')]);
        }
        $evaluation->load(['offer', 'offer.application', 'offer.application.applicant']);
        if(!$evaluation->offer->application->projectcall->canEvaluate()){
            return redirect()->route('home')
                             ->withErrors([__('actions.projectcall.cannot_evaluate_anymore')]);
        }
        return view('evaluation.edit', compact('evaluation'));
    }

    /**
     * Updates the evaluation.
     *
     * @param  Evaluation  $evaluation
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Evaluation $evaluation, Request $request)
    {
        if(!empty($evaluation->submitted_at)){
            return redirect()->route('home')
                             ->withErrors([__('actions.evaluation.already_submitted')]);
        }
        if(!$evaluation->offer->application->projectcall->canEvaluate()){
            return redirect()->route('home')
                             ->withErrors([__('actions.projectcall.cannot_evaluate_anymore')]);
        }
        $data = $request->all();
        $evaluation->fill($data);
        $evaluation->save();

        return redirect()->route('home')
                         ->with('success', __('actions.evaluation.saved'));
    }

    /**
     * Submits the evaluation.
     *
     * @param  Evaluation  $evaluation
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function submit(Evaluation $evaluation, Request $request)
    {
        if(!empty($evaluation->submitted_at)){
            return redirect()->route('home')
                             ->withErrors([__('actions.evaluation.already_submitted')]);
        }
        if(!$evaluation->offer->application->projectcall->canEvaluate()){
            return redirect()->route('home')
                             ->withErrors([__('actions.projectcall.cannot_evaluate_anymore')]);
        }
        $data = $evaluation->attributesToArray();
        $validator = Validator::make($data, [
            'grade1'         => 'required|integer|min:0|max:3',
            'comment1'       => 'required|string',
            'grade2'         => 'required|integer|min:0|max:3',
            'comment2'       => 'required|string',
            'grade3'         => 'required|integer|min:0|max:3',
            'comment3'       => 'required|string',
            'global_grade'   => 'required|integer|min:0|max:3',
            'global_comment' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()
                        ->route('evaluation.edit', ["evaluation" => $evaluation])
                        ->withErrors($validator)
                        ->withInput();
        }

        $evaluation->submitted_at = \Carbon\Carbon::now();
        $evaluation->save();

        Notification::send(User::admins()->get(), new EvaluationSubmitted($evaluation->offer));

        return redirect()->route('home')
                         ->with('success', __('actions.evaluation.submitted'));
    }
}
