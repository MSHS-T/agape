<?php

namespace App\Filament\Applicant\Pages;

use App\Filament\AgapeApplicationForm;
use App\Filament\AgapeForm;
use App\Models\Application;
use App\Models\ProjectCall;
use App\Models\StudyField;
use App\Settings\GeneralSettings;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Form;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Apply extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $view            = 'filament.applicant.pages.apply';
    protected static ?int $navigationSort    = 20;

    public ProjectCall $projectCall;
    public ?Application $application = null;

    public ?array $data = [];

    public function mount(): void
    {
        $projectCallId = request()->query('projectCall');
        $projectCall = ProjectCall::with([
            'projectCallType',
            'applications' => function ($query) {
                $query->where('applicant_id', Auth::id());
            }
        ])->find($projectCallId);

        $application = $projectCall->getApplication();
        if (blank($application)) {
            $this->application = new Application([
                'project_call_id' => $projectCall->id
            ]);
            self::$title = __('pages.apply.title_create');
        } else {
            $this->application = $application;
            if (filled($this->application->devalidation_message)) {
                self::$title = __('pages.apply.title_correct');
            } else {
                self::$title = __('pages.apply.title_edit');
            }
        }

        $this->projectCall = $projectCall;
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return (new AgapeApplicationForm($this->projectCall, $form))
            ->buildForm()
            ->model($this->application)
            ->statePath('data');
    }

    public function saveDraft()
    {
        ray(__FUNCTION__, $this->application, $this->form->getState());
        // $this->application->save();
        // $this->loadProjectCall($this->projectCall->fresh());
    }

    public function submitApplication()
    {
        ray(__FUNCTION__, $this->application);
        // $this->application->save();
        // $this->loadProjectCall($this->projectCall->fresh());
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}
