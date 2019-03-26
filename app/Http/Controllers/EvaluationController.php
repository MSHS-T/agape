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
     * Display the specified resource.
     *
     * @param  Evaluation  $evaluation
     * @return \Illuminate\Http\Response
     */
    public function show($evaluation)
    {
        return view('evaluation.show', compact('evaluation'));
    }

    /**
     * Show the form for the evaluation.
     *
     * @param  EvaluationOffer  $offer
     * @return \Illuminate\Http\Response
     */
    public function create(EvaluationOffer $offer)
    {
        $offer->load(['application', 'application.applicant']);
        return view('evaluation.create', compact('offer'));
    }

    /**
     * Stores the evaluation.
     *
     * @param  EvaluationOffer  $offer
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EvaluationOffer $offer, Request $request)
    {
        $data = $request->all();
        $offer->evaluation()->create($data);

        Notification::send(User::admins()->get(), new EvaluationSubmitted($offer));

        return redirect()->route('home')
                         ->with('success', __('actions.evaluation.submitted'));
    }
}
