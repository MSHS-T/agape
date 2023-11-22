<?php

namespace App\Filament\Expert\Pages;

use App\Models\EvaluationOffer;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class Dashboard extends Page
{
    protected static string $view = 'filament.expert.pages.dashboard';
    protected static ?string $navigationIcon = 'fas-home';
    protected static ?int $navigationSort    = 10;

    public array $openOffers = [];
    public array $pendingEvaluation = [];
    public array $doneEvaluation = [];

    public function mount(): void
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->openOffers = EvaluationOffer::affectedToMe()
            ->pendingReply()
            ->get()
            // Keep only offers for call in the evaluation phase
            ->filter(fn (EvaluationOffer $offer) => $offer->application->projectCall->canEvaluate())
            ->all();
        $this->pendingEvaluation = EvaluationOffer::affectedToMe()
            ->accepted()
            ->evaluationPending()
            ->get()
            // Keep only offers for call in the evaluation phase
            ->filter(fn (EvaluationOffer $offer) => $offer->application->projectCall->canEvaluate())
            ->all();
        $this->doneEvaluation = EvaluationOffer::with('evaluation')
            ->affectedToMe()
            ->evaluationDone()
            ->get()
            // Keep only offers for call NOT in the evaluation phase
            // (but with evaluationDone() scope, it means the evaluation period is in the past and expert has submitted the evaluation)
            ->filter(fn (EvaluationOffer $offer) => !$offer->application->projectCall->canEvaluate())
            ->all();
    }

    public static function getNavigationLabel(): string
    {
        return __('admin.dashboard.title');
    }

    public function getTitle(): string | Htmlable
    {
        return __('admin.dashboard.title');
    }
}
