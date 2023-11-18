<?php

namespace App\Filament\Applicant\Pages;

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
        $generalSettings = app(GeneralSettings::class);
        $files = collect(['applicationForm', 'financialForm', 'additionalInformation', 'otherAttachments'])
            ->filter(fn ($name) => $generalSettings->{'enable' . ucfirst($name)} ?? false);
        return $form
            ->schema([
                Forms\Components\Hidden::make('project_call_id')->default($this->projectCall->id),
                Forms\Components\Section::make('general')
                    ->heading(__('pages.apply.sections.general'))
                    ->collapsible()
                    ->columns([
                        'default' => 1,
                        'sm'      => 2,
                        'lg'      => 4,
                    ])
                    ->schema([
                        Forms\Components\TextInput::make('acronym')
                            ->label(__('attributes.acronym'))
                            ->columnSpan([
                                'default' => 1,
                                'sm'      => 2,
                                'lg'      => 1,
                            ]),
                        Forms\Components\TextInput::make('title')
                            ->label(__('attributes.title'))
                            ->columnSpan([
                                'default' => 1,
                                'sm'      => 2,
                                'lg'      => 3,
                            ]),
                        Forms\Components\Fieldset::make(__('attributes.carrier'))
                            ->columns([
                                'default' => 1,
                                'sm'      => 2,
                                'lg'      => 3,
                            ])
                            ->schema([
                                Forms\Components\TextInput::make('carrier.last_name')
                                    ->label(__('attributes.first_name')),
                                Forms\Components\TextInput::make('carrier.first_name')
                                    ->label(__('attributes.last_name')),
                                Forms\Components\TextInput::make('carrier.email')
                                    ->label(__('attributes.email'))
                                    ->email(),
                                Forms\Components\TextInput::make('carrier.phone')
                                    ->label(__('attributes.phone')),
                                Forms\Components\TextInput::make('carrier.status')
                                    ->label(__('attributes.status')),
                            ]),
                        Forms\Components\Fieldset::make(__('resources.laboratory_plural'))
                            ->columns(1)
                            ->columnSpanFull()
                            ->schema([
                                Forms\Components\Repeater::make('applicationLaboratories')
                                    ->label(false)
                                    ->helperText(__('pages.apply.laboratories_help'))
                                    ->relationship()
                                    ->schema([
                                        Forms\Components\Select::make('laboratory_id')
                                            ->label(false)
                                            ->relationship(
                                                name: 'laboratory',
                                                titleAttribute: 'name',
                                                modifyQueryUsing: fn (Builder $query) => $query->where(
                                                    fn (Builder $query) => $query->whereNull('creator_id')->orWhere('creator_id', Auth::id())
                                                )
                                            )
                                            ->searchable()
                                            ->preload()
                                            ->createOptionForm([
                                                Forms\Components\TextInput::make('name')
                                                    ->label(__('attributes.name')),
                                                Forms\Components\TextInput::make('unit_code')
                                                    ->label(__('attributes.unit_code')),
                                                Forms\Components\TextInput::make('director_email')
                                                    ->label(__('attributes.director_email'))
                                                    ->email(),
                                                Forms\Components\TextInput::make('regency')
                                                    ->label(__('attributes.regency')),
                                            ])
                                            ->createOptionModalHeading(__('pages.apply.create_laboratory'))
                                            ->editOptionModalHeading(__('pages.apply.edit_laboratory'))
                                            ->editOptionForm([
                                                Forms\Components\TextInput::make('name')
                                                    ->label(__('attributes.name'))
                                                    ->disabled(),
                                                Forms\Components\TextInput::make('unit_code')
                                                    ->label(__('attributes.unit_code'))
                                                    ->disabled(),
                                                Forms\Components\TextInput::make('director_email')
                                                    ->label(__('attributes.director_email'))
                                                    ->email(),
                                                Forms\Components\TextInput::make('regency')
                                                    ->label(__('attributes.regency'))
                                                    ->disabled(),
                                            ]),
                                    ])
                                    ->columnSpanFull()
                                    ->reorderable()
                                    ->orderColumn('order')
                                    ->reorderableWithButtons()
                                    ->reorderableWithDragAndDrop(false)
                                    ->addActionLabel(__('pages.apply.add_laboratory'))
                                    ->maxItems($this->projectCall->extra_attributes->number_of_laboratories)
                                    ->grid([
                                        'default' => 1,
                                        'sm'      => 2,
                                        'lg'      => 2,
                                    ]),
                                AgapeForm::richTextEditor('other_laboratories')
                                    ->label(__('attributes.other_laboratories'))
                                    ->columnSpanFull(),
                            ]),
                        Forms\Components\Repeater::make('keywords')
                            ->label(__('attributes.keywords'))
                            ->addActionLabel(__('pages.apply.add_keyword'))
                            ->simple(
                                Forms\Components\TextInput::make('value'),
                            )
                            ->default([''])
                            ->grid(3)
                            ->reorderable(false)
                            ->columnSpanFull()
                    ]),
                Forms\Components\Section::make('scientific')
                    ->heading(__('pages.apply.sections.scientific'))
                    ->collapsible()
                    ->columns([
                        'default' => 1,
                        'sm'      => 2,
                        'lg'      => 4,
                    ])
                    ->schema([
                        AgapeForm::richTextEditor('short_description')
                            ->label(__('attributes.short_description'))
                            ->columnSpanFull(),
                        AgapeForm::richTextEditor('summary.fr')
                            ->label(__('attributes.summary_fr'))
                            ->columnSpan([
                                'default' => 1,
                                'sm'      => 1,
                                'lg'      => 2,
                            ]),
                        AgapeForm::richTextEditor('summary.en')
                            ->label(__('attributes.summary_en'))
                            ->columnSpan([
                                'default' => 1,
                                'sm'      => 1,
                                'lg'      => 2,
                            ]),
                        Forms\Components\Select::make('studyFields')
                            ->label(__('resources.study_field_plural'))
                            ->helperText(__('pages.apply.study_fields_help'))
                            ->multiple()
                            ->relationship(
                                name: 'studyFields',
                                modifyQueryUsing: fn (Builder $query) => $query->where(
                                    fn (Builder $query) => $query->whereNull('creator_id')->orWhere('creator_id', Auth::id())
                                )
                            )
                            ->getOptionLabelFromRecordUsing(fn (StudyField $record) => $record->name)
                            ->columnSpanFull()
                            ->searchable()
                            ->preload()
                            ->maxItems($this->projectCall->extra_attributes->number_of_study_fields)
                            ->createOptionForm([
                                AgapeForm::translatableFields($form, fn ($lang) => [
                                    Forms\Components\TextInput::make('name.' . $lang)
                                        ->label(__('attributes.name'))
                                        ->required(),
                                ], 'pages.apply.create_study_field_help'),
                            ])
                            ->createOptionModalHeading(__('pages.apply.create_study_field'))
                    ]),
                Forms\Components\Section::make('budget')
                    ->heading(__('pages.apply.sections.budget'))
                    ->collapsible()
                    ->columns([
                        'default' => 1,
                        'sm'      => 2,
                        'lg'      => 4,
                    ])
                    ->schema([
                        Forms\Components\TextInput::make('amount_requested')
                            ->label(__('attributes.amount_requested'))
                            ->helperText(__('pages.apply.amount_requested_help'))
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->step(0.01)
                            ->suffix('€')
                            ->columnSpan([
                                'default' => 1,
                                'sm'      => 2,
                                'lg'      => 2,
                            ]),
                        Forms\Components\TextInput::make('other_fundings')
                            ->label(__('attributes.other_fundings'))
                            ->helperText(__('pages.apply.other_fundings_help'))
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->step(0.01)
                            ->suffix('€')
                            ->columnSpan([
                                'default' => 1,
                                'sm'      => 2,
                                'lg'      => 2,
                            ]),
                        Forms\Components\TextInput::make('total_expected_income')
                            ->label(__('attributes.total_expected_income'))
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->step(0.01)
                            ->suffix('€')
                            ->columnSpan([
                                'default' => 1,
                                'sm'      => 2,
                                'lg'      => 2,
                            ]),
                        Forms\Components\TextInput::make('total_expected_outcome')
                            ->label(__('attributes.total_expected_outcome'))
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->step(0.01)
                            ->suffix('€')
                            ->columnSpan([
                                'default' => 1,
                                'sm'      => 2,
                                'lg'      => 2,
                            ]),
                    ]),
                Forms\Components\Section::make('files')
                    ->heading(__('pages.apply.sections.files'))
                    ->collapsible()
                    ->columns([
                        'default' => 1,
                        'sm'      => 2,
                        'lg'      => 4,
                    ])
                    ->schema([
                        ...$files
                            ->map(
                                function ($fileName) {
                                    $field = AgapeForm::fileField($fileName)
                                        ->columnSpanFull();
                                    if ($fileName === 'otherAttachments') {
                                        $maxFiles = $this->projectCall->extra_attributes->number_of_documents;
                                        $helperText = Str::of($field->getHelperText())
                                            ->append('<br/>', __('pages.apply.other_attachments_help', ['count' => $maxFiles]))
                                            ->toHtmlString();

                                        $field = $field->multiple()
                                            ->reorderable()
                                            ->maxFiles($maxFiles)
                                            ->helperText($helperText);
                                    }

                                    return $field;
                                }
                            )
                            ->all()
                    ]),
            ])
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
