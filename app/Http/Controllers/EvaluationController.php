<?php

namespace App\Http\Controllers;

use App\Evaluation;
use App\EvaluationOffer;
use App\User;
use App\Notifications\OfferAccepted;
use App\Notifications\OfferDeclined;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class EvaluationController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $evaluation = Evaluation::findOrFail($id);
        return view('evaluation.show', compact('evaluation'));
    }

    /**
     * Show the form for the evaluation.
     *
     * @param  int $offer_id
     * @return \Illuminate\Http\Response
     */
    public function create($offer_id)
    {
        $offer = EvaluationOffer::with(['application', 'application.applicant'])
            ->findOrFail($offer_id);
        return view('evaluation.create', compact('offer'));
    }

    /**
     * Stores the evaluation.
     *
     * @param  int $offer_id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($offer_id, Request $request)
    {
        $offer = EvaluationOffer::findOrFail($offer_id);

        $data = $request->all();
        // $evaluation = new Evaluation($data);
        $offer->evaluation()->create($data);

        //TODO : Notify admin of evaluation submission
        return redirect()->route('home')
                         ->with('success', __('actions.evaluation.submitted'));
    }

    /**
     * Accepts the evaluation offer.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EvaluationOffer  $offer
     * @return \Illuminate\Http\Response
     */
    public function acceptOffer(Request $request, $offer_id)
    {
        $offer = EvaluationOffer::findOrFail($offer_id);
        $offer->accepted = true;
        $offer->save();
        Notification::send(User::admins()->get(), new OfferAccepted($offer));
        return redirect()->route('evaluation.create', ["offer_id" => $offer_id])
                         ->with('success', __('actions.evaluationoffers.accepted'));
    }

    /**
     * Accepts the evaluation offer.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EvaluationOffer  $offer
     * @return \Illuminate\Http\Response
     */
    public function declineOffer(Request $request, $offer_id)
    {
        $offer = EvaluationOffer::findOrFail($offer_id);
        $offer->accepted = false;
        $offer->justification = $request->input('justification');
        $offer->save();
        Notification::send(User::admins()->get(), new OfferDeclined($offer));
        return redirect()->route('home')
                         ->with('success', __('actions.evaluationoffers.declined'));
    }
}
