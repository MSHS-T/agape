<?php

namespace App\Http\Controllers;

use App\Evaluation;
use App\EvaluationOffer;

use Illuminate\Http\Request;

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
        return redirect()->route('home')
                         ->with('success', __('actions.evaluationoffers.declined'));
    }
}
