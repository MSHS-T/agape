<?php

namespace App\Http\Controllers;

use App\Application;
use App\Evaluation;
use App\EvaluationOffer;
use App\ProjectCall;
use App\User;
use App\Notifications\EvaluationForceSubmitted;
use App\Notifications\EvaluationSubmitted;
use App\Notifications\EvaluationUnsubmitted;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

use PDF;

class EvaluationController extends Controller
{
    /**
     * Display the evaluations for a specific projectcall.
     *
     * @param  int $projectcall
     * @return \Illuminate\Http\Response
     */
    public function indexForProjectCall(int $projectcall)
    {
        $projectcall = ProjectCall::withTrashed()->findOrFail($projectcall);
        $evaluations = collect([]);
        foreach ($projectcall->submittedApplications as $application) {
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
     * @param  int $projectcall
     * @return \Illuminate\Http\Response
     */
    public function exportForProjectCall(int $projectcall, Request $request)
    {
        $projectcall = ProjectCall::withTrashed()->findOrFail($projectcall);
        $projectcall->load('submittedApplications')->load(['submittedApplications.evaluations' => function ($query) {
            $query->whereNotNull('submitted_at');
        }]);

        $title = implode(' - ', [
            config('app.name'),
            __('actions.evaluation.export_name'),
            $projectcall->type->label_short,
            $projectcall->year
        ]);

        $pdf = PDF::loadView('export.evaluations_projectcall', [
            'applications' => $projectcall->submittedApplications()->get(),
            'projectcall' => $projectcall,
            'anonymized' => boolval($request->input('anonymized', "0")),
        ]);
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
        $application->load('projectcall')->load(['evaluations' => function ($query) {
            $query->whereNotNull('submitted_at');
        }]);

        $title = implode(' - ', [
            config('app.name'),
            __('actions.evaluation.export_name'),
            $application->projectcall->type->label_short,
            $application->projectcall->year
        ]);

        $pdf = PDF::loadView('export.evaluations_application', [
            'application' => $application,
            'projectcall' => $application->projectcall,
            'anonymized' => boolval($request->input('anonymized', "0"))
        ]);
        return $pdf->download($title . '.pdf');
    }

    /**
     * Export a single evaluation
     *
     * @param  Evaluation  $evaluation
     * @return \Illuminate\Http\Response
     */
    public function export(Evaluation $evaluation, Request $request)
    {
        $title = implode(' - ', [
            config('app.name'),
            __('actions.evaluation.export_name'),
            $evaluation->offer->application->projectcall->type->label_short,
            $evaluation->offer->application->projectcall->year
        ]);

        $pdf = PDF::loadView('export.evaluation', [
            'evaluation' => $evaluation,
            'projectcall' => $evaluation->offer->application->projectcall,
            'anonymized' => boolval($request->input('anonymized', "0"))
        ]);
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
        if (!empty($evaluation->submitted_at)) {
            return redirect()->route('home')
                ->withErrors([__('actions.evaluation.already_submitted')]);
        }
        $evaluation->load(['offer', 'offer.application', 'offer.application.applicant']);
        if (!$evaluation->offer->application->projectcall->canEvaluate() && $evaluation->devalidation_message == null) {
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
        if (!empty($evaluation->submitted_at)) {
            return redirect()->route('home')
                ->withErrors([__('actions.evaluation.already_submitted')]);
        }
        if (!$evaluation->offer->application->projectcall->canEvaluate()) {
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
        if (!empty($evaluation->submitted_at)) {
            return redirect()->route('home')
                ->withErrors([__('actions.evaluation.already_submitted')]);
        }
        if (!$evaluation->offer->application->projectcall->canEvaluate() && $evaluation->devalidation_message == null) {
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

    /**
     * Forces evaluation submission
     *
     * @param  \App\Evaluation  $evaluation
     * @return \Illuminate\Http\Response
     */
    public function forceSubmit(Evaluation $evaluation)
    {
        if (!empty($evaluation->submitted_at)) {
            return redirect()->route('projectcall.evaluations', ['projectcall' => $evaluation->projectcall])
                ->withErrors([__('actions.evaluation.already_submitted', ['reference' => $evaluation->reference])]);
        }

        $evaluation->submitted_at = \Carbon\Carbon::now();
        $evaluation->save();

        // Notify applicant
        $evaluation->offer->expert->notify(new EvaluationForceSubmitted($evaluation));

        return redirect()->back()
            ->with('success', __('actions.evaluation.force_submitted', ['reference' => $evaluation->reference]));
    }

    /**
     * Un-submit evaluation
     *
     * @param  \App\Evaluation  $evaluation
     * @return \Illuminate\Http\Response
     */
    public function unsubmit(Evaluation $evaluation, Request $request)
    {
        $evaluation->submitted_at = null;
        $evaluation->devalidation_message = $request->input('justification');
        $evaluation->save();

        // Notify expert
        $evaluation->offer->expert->notify(new EvaluationUnsubmitted($evaluation));

        return redirect()->back()
            ->with('success', __('actions.evaluation.unsubmitted', ['reference' => $evaluation->reference]));
    }
}
