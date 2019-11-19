<?php

namespace App\Http\Controllers;

use App\Application;
use App\Evaluation;
use App\EvaluationOffer;
use App\User;
use App\Notifications\OfferAccepted;
use App\Notifications\OfferCreated;
use App\Notifications\OfferDeclined;
use App\Notifications\OfferRetry;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class EvaluationOfferController extends Controller
{
    /**
     * Assign an expert to an application
     *
     * @param  Application  $application
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Application $application, Request $request)
    {
        $application->load(['projectcall', 'offers', 'offers.expert']);
        $expert = User::findOrFail($request->input('expert_id'));
        $offer = $application->offers()->firstOrNew(['expert_id' => $expert->id]);
        $offer->save();

        $expert->notify(new OfferCreated($application->projectcall));

        return redirect()->route('application.assignations', ['application' => $application])
                         ->with('success', __('actions.application.expert_assigned'));
    }

    /**
     * Remove an assignation
     *
     * @param  EvaluationOffer $offer
     * @return \Illuminate\Http\Response
     */
    public function destroy(EvaluationOffer $offer)
    {
        $application = $offer->application;
        $offer->delete();
        return redirect()->route('application.assignations', ['application' => $application])
                         ->with('success', __('actions.application.expert_unassigned'));
    }

    /**
     * Sends a reminder email to expert to process the evaluation offer
     *
     * @param  EvaluationOffer  $offer
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function retry(EvaluationOffer $offer, Request $request)
    {
        $offer->expert->notify(new OfferRetry($offer));

        return redirect()->route('application.assignations', ['application' => $offer->application])
                         ->with('success', __('actions.evaluationoffers.reminder_sent'));
    }

    /**
     * Accepts the evaluation offer.
     *
     * @param  \App\EvaluationOffer  $offer
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function accept(EvaluationOffer $offer, Request $request)
    {
        if(!$offer->application->projectcall->canEvaluate()){
            return redirect()->route('home')
                             ->withErrors([__('actions.projectcall.cannot_evaluate_anymore')]);
        }
        if($offer->accepted != null){
            return redirect()->route('home')
                             ->withErrors([__('actions.evaluationoffers.already_answered')]);
        }
        $offer->accepted = true;
        $evaluation = $offer->evaluation()->first() ?? $offer->evaluation()->save(new Evaluation);
        $offer->save();
        Notification::send(User::admins()->get(), new OfferAccepted($offer));
        return redirect()->route('evaluation.edit', ["evaluation" => $evaluation])
                         ->with('success', __('actions.evaluationoffers.accepted'));
    }

    /**
     * Accepts the evaluation offer.
     *
     * @param  \App\EvaluationOffer  $offer
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function decline(EvaluationOffer $offer, Request $request)
    {
        if(!$offer->application->projectcall->canEvaluate()){
            return redirect()->route('home')
                             ->withErrors([__('actions.projectcall.cannot_evaluate_anymore')]);
        }
        if($offer->accepted != null){
            return redirect()->route('home')
                             ->withErrors([__('actions.evaluationoffers.already_answered')]);
        }
        $offer->accepted = false;
        $offer->justification = $request->input('justification');
        $offer->save();
        Notification::send(User::admins()->get(), new OfferDeclined($offer));
        return redirect()->route('home')
                         ->with('success', __('actions.evaluationoffers.declined'));
    }
}
