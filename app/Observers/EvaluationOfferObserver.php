<?php

namespace App\Observers;

use App\Models\EvaluationOffer;
use App\Notifications\EvaluationOfferExistingExpert;
use App\Notifications\EvaluationOfferNewExpert;
use App\Notifications\EvaluationOfferRetryExistingExpert;
use App\Notifications\EvaluationOfferRetryNewExpert;

class EvaluationOfferObserver
{
    /**
     * Handle the EvaluationOffer "created" event.
     */
    public function created(EvaluationOffer $evaluationOffer): void
    {
        if (filled($evaluationOffer->expert)) {
            $evaluationOffer->expert->notify((new EvaluationOfferExistingExpert($evaluationOffer)));
        } else if (filled($evaluationOffer->invitation)) {
            $evaluationOffer->invitation->notify((new EvaluationOfferNewExpert($evaluationOffer)));
        }
    }

    /**
     * Handle the EvaluationOffer "updated" event.
     */
    public function updated(EvaluationOffer $evaluationOffer): void
    {
        if (filled($evaluationOffer->expert)) {
            $evaluationOffer->expert->notify((new EvaluationOfferRetryExistingExpert($evaluationOffer)));
        } else if (filled($evaluationOffer->invitation)) {
            $evaluationOffer->invitation->notify((new EvaluationOfferRetryNewExpert($evaluationOffer)));
        }
    }
}
