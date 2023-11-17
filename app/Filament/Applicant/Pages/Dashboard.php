<?php

namespace App\Filament\Applicant\Pages;

use App\Models\ProjectCall;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Page
{
    protected static string $view = 'filament.applicant.pages.dashboard';

    protected static ?string $navigationIcon = 'fas-home';

    public array $openCalls = [];

    public function mount(): void
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->openCalls = ProjectCall::with(['projectCallType', 'applications' => function ($query) {
            $query->where('applicant_id', Auth::id());
        }])
            ->open()
            ->get()
            ->filter(fn (ProjectCall $projectCall) => $projectCall->showForApplicant())
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
