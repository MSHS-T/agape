<?php

namespace App\Filament\Expert\Pages;

use App\Filament\AgapeApplicationForm;
use App\Filament\AgapeEvaluationForm;
use App\Models\Evaluation;
use App\Models\EvaluationOffer;
use App\Rulesets\Evaluation as EvaluationRuleset;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Colors\Color;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\HtmlString;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class Evaluate extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'filament.expert.pages.evaluate';

    public EvaluationOffer $evaluationOffer;
    public ?Evaluation $evaluation = null;

    public ?array $data = [];
    public ?array $applicationData = [];

    public array $initialState;

    public function mount(): void
    {
        $offerId = request()->query('offer');
        $this->loadOffer(intval($offerId));
    }

    public function loadOffer(int $offerId)
    {
        $evaluationOffer = EvaluationOffer::with([
            'application',
            'application.creator',
            'application.projectCall',
            'evaluation'
        ])->find($offerId);

        $evaluation = $evaluationOffer->evaluation;

        if (blank($evaluation)) {
            $this->evaluation = new Evaluation([
                'evaluation_offer_id' => $evaluationOffer->id,
                'notation' => $evaluationOffer->application->projectCall->notation,
            ]);
            self::$title = __('pages.evaluate.title_create');
        } else {
            $this->evaluation = $evaluation;
            if (filled($this->evaluation->devalidation_message)) {
                self::$title = __('pages.evaluate.title_correct');
            } else {
                self::$title = __('pages.evaluate.title_edit');
            }
        }

        $this->evaluationOffer = $evaluationOffer;
        $this->form->fill($this->evaluation->toArray());
        $this->applicationForm->fill($this->evaluationOffer->application->toArray());
        $this->initialState = $this->form->getRawState();
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Section::make('help')
                ->heading(__('pages.evaluate.help'))
                ->icon('fas-circle-info')
                ->iconColor(Color::Blue)
                ->collapsible()
                ->schema([
                    Placeholder::make('help')
                        ->hiddenLabel()
                        ->content(new HtmlString($this->evaluationOffer->application->projectCall->help_experts))
                ]),
            ...(new AgapeEvaluationForm($this->evaluationOffer, $form))
                ->buildForm(),
            $this->buildActions()
        ])
            ->model($this->evaluationOffer)
            ->statePath('data');
    }

    public function applicationForm(Form $form): Form
    {
        return $form->schema([
            ...(new AgapeApplicationForm($this->evaluationOffer->application->projectCall, $form, forEvaluation: true))
                ->buildForm()
        ])
            ->disabled()
            ->model($this->evaluationOffer->application)
            ->statePath('applicationData');
    }

    protected function buildActions(): Actions
    {
        return Actions::make([
            Action::make('back')
                ->label(__('pages.evaluate.back'))
                ->icon('fas-arrow-left')
                ->color('secondary')
                ->requiresConfirmation(fn (Component $livewire) => $livewire->isDirty())
                ->action(function () {
                    return redirect()->route('filament.expert.pages.dashboard');
                }),
            Action::make('save')
                ->label(__('pages.evaluate.save'))
                ->icon('fas-save')
                ->color('primary')
                ->hidden(!$this->evaluationOffer->application->projectCall->canEvaluate() || filled($this->evaluation->submitted_at))
                ->action(function (Component $livewire) {
                    $livewire->resetErrorBag();
                    $this->saveDraft();
                }),
            Action::make('submit')
                ->label(__('pages.evaluate.submit'))
                ->icon('fas-paper-plane')
                ->color('success')
                ->hidden(!$this->evaluationOffer->application->projectCall->canEvaluate() || filled($this->evaluation->submitted_at))
                // ->disabled(fn (Component $livewire) => $livewire->isDirty())
                // ->tooltip(__('pages.evaluate.submit_disabled'))
                ->requiresConfirmation(fn (Component $livewire) => !$livewire->isDirty())
                ->modalIcon(fn (Component $livewire) => !$livewire->isDirty() ? 'fas-paper-plane' : null)
                ->modalIconColor(fn (Component $livewire) => !$livewire->isDirty() ? 'success' : null)
                ->modalHeading(fn (Component $livewire) => !$livewire->isDirty() ? __('pages.evaluate.submit_confirmation_title') : null)
                ->modalDescription(fn (Component $livewire) => !$livewire->isDirty() ? __('pages.evaluate.submit_confirmation_text') : null)
                ->modalSubmitActionLabel(fn (Component $livewire) => !$livewire->isDirty() ? __('pages.evaluate.submit_confirmation_button') : null)
                ->action(function () {
                    $this->submitApplication();
                })
        ])
            ->columnSpanFull()
            ->alignCenter()
            ->view('components.filament.actions-container');
    }

    public function saveDraft()
    {
        $formData = $this->form->getRawState();

        $this->evaluation->evaluationOffer()->associate($this->evaluationOffer);
        $this->evaluation->fill($formData);

        $this->evaluation->save();

        // Reload form
        $this->loadOffer($this->evaluationOffer->id);

        Notification::make()
            ->title(__('pages.evaluate.save_success'))
            ->success()
            ->send();
    }

    public function submitApplication()
    {
        if ($this->isDirty()) {
            Notification::make()
                ->title(__('pages.evaluate.save_before_submitting'))
                ->danger()
                ->send();
            throw \Illuminate\Validation\ValidationException::withMessages([]);
        }
        $formData = $this->form->getRawState();
        $projectCall = $this->evaluationOffer->application->projectCall;

        $validator = Validator::make(
            $formData,
            EvaluationRuleset::rules($projectCall),
            EvaluationRuleset::messages($projectCall),
            EvaluationRuleset::attributes($projectCall),
        );
        if ($validator->fails()) {
            $errors = collect($validator->errors()->messages())
                ->mapWithKeys(fn ($messages, $key) => ['data.' . $key => $messages])->all();
            $this->dispatch('close-modal', id: "{$this->getId()}-form-component-action");

            Notification::make()
                ->title(__('pages.evaluate.submit_error'))
                ->danger()
                ->send();
            throw \Illuminate\Validation\ValidationException::withMessages($errors);
        }
        $this->evaluation->submit();

        Notification::make()
            ->title(__('pages.evaluate.submit_success'))
            ->success()
            ->send();

        $this->loadOffer($this->evaluationOffer->id);
    }

    public function isDirty(): bool
    {
        return $this->form->getRawState() !== $this->initialState;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    protected function getForms(): array
    {
        return [
            'form',
            'applicationForm',
        ];
    }
}
