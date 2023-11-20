<?php

namespace App\Filament;

use App\Models\ProjectCall;
use App\Models\StudyField;
use App\Settings\GeneralSettings;
use Filament\Forms;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AgapeApplicationForm
{
    public function __construct(protected ProjectCall $projectCall, protected Forms\Form $form)
    {
    }

    public function buildForm(): Forms\Form
    {
        return $this->form
            ->schema([
                Forms\Components\Hidden::make('project_call_id')->default($this->projectCall->id),
                self::buildSection('general'),
                self::buildSection('scientific'),
                self::buildSection('budget'),
                self::buildSection('files'),
            ]);
    }

    public static function fieldsPerSection(): array
    {
        return [
            'general'    => [
                'acronym'      => __('attributes.acronym'),
                'title'        => __('attributes.title'),
                'carrier'      => __('attributes.carrier'),
                'laboratories' => __('resources.laboratory_plural'),
                'studyFields'  => __('resources.study_field_plural'),
                'keywords'     => __('attributes.keywords'),
            ],
            'scientific' => [
                'short_description' => __('attributes.short_description'),
                'summary.fr'        => __('attributes.summary_fr'),
                'summary.en'        => __('attributes.summary_en'),
            ],
            'budget'     => [
                'amount_requested'       => __('attributes.amount_requested'),
                'other_fundings'         => __('attributes.other_fundings'),
                'total_expected_income'  => __('attributes.total_expected_income'),
                'total_expected_outcome' => __('attributes.total_expected_outcome'),
            ],
            'files'      => [
                'applicationForm'       => __('attributes.files.applicationForm'),
                'financialForm'         => __('attributes.files.financialForm'),
                'additionalInformation' => __('attributes.files.additionalInformation'),
                'otherAttachments'      => __('attributes.files.otherAttachments'),
            ]
        ];
    }

    public function buildSection(string $section): Forms\Components\Section
    {
        $generalSettings = app(GeneralSettings::class);
        $dynamicFields = collect($this->projectCall->projectCallType->dynamic_attributes ?? [])->filter(fn ($field) => $field['section'] === $section);
        $fieldsWithLabels = static::fieldsPerSection()[$section];

        // special case for fields of file section
        if ($section === 'files') {
            $fieldsWithLabels = array_filter(
                $fieldsWithLabels,
                fn ($name) => $generalSettings->{'enable' . ucfirst($name)},
                ARRAY_FILTER_USE_KEY
            );
        }
        $sectionFields = collect([]);

        foreach ($fieldsWithLabels as $fieldName => $label) {
            $sectionFields->push(
                $this->getField($fieldName)->label($label),
                ...$dynamicFields
                    ->filter(fn ($field) => $field['after_field'] === $fieldName)
                    ->map(fn ($field) => $this->getDynamicField($field))
                    ->all()
            );
        }
        $sectionFields->push(
            ...$dynamicFields
                ->filter(fn ($field) => !in_array($field['after_field'], array_keys($fieldsWithLabels)))
                ->map(fn ($field) => $this->getDynamicField($field))
                ->all()
        );

        return Forms\Components\Section::make($section)
            ->heading(__('pages.apply.sections.' . $section))
            ->collapsible()
            ->columns([
                'default' => 1,
                'sm'      => 2,
                'lg'      => 4,
            ])
            ->schema($sectionFields->filter(fn ($f) => $f !== null)->all());
    }

    public function getField(string $name): null|Forms\Components\Field|Forms\Components\Fieldset
    {
        switch ($name) {
                /**
             * GENERAL SECTION
             */
            case 'acronym':
                return Forms\Components\TextInput::make('acronym')
                    ->columnSpan(['default' => 1, 'sm' => 2, 'lg' => 1]);
            case 'title':
                return Forms\Components\TextInput::make('title')
                    ->columnSpan(['default' => 1, 'sm' => 2, 'lg' => 3]);
            case 'carrier':
                return Forms\Components\Fieldset::make('carrier')
                    ->columns(['default' => 1, 'sm' => 2, 'lg' => 3])
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
                    ]);
            case 'laboratories':
                return Forms\Components\Fieldset::make('laboratories')
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
                            ->grid(['default' => 1, 'sm' => 2, 'lg' => 2]),
                        AgapeForm::richTextEditor('other_laboratories')
                            ->label(__('attributes.other_laboratories'))
                            ->columnSpanFull(),
                    ]);
            case 'keywords':
                return Forms\Components\Repeater::make('keywords')
                    ->addActionLabel(__('pages.apply.add_keyword'))
                    ->simple(
                        Forms\Components\TextInput::make('value'),
                    )
                    ->default([''])
                    ->grid(3)
                    ->reorderable(false)
                    ->columnSpanFull();
                /**
                 * SCIENTIFIC SECTION
                 */
            case 'short_description':
                return AgapeForm::richTextEditor('short_description')
                    ->columnSpanFull();
            case 'summary.fr':
                return AgapeForm::richTextEditor('summary.fr')
                    ->columnSpan([
                        'default' => 1,
                        'sm'      => 1,
                        'lg'      => 2,
                    ]);
            case 'summary.en':
                return AgapeForm::richTextEditor('summary.en')
                    ->columnSpan([
                        'default' => 1,
                        'sm'      => 1,
                        'lg'      => 2,
                    ]);
            case 'studyFields':
                return Forms\Components\Select::make('studyFields')
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
                        AgapeForm::translatableFields($this->form, fn ($lang) => [
                            Forms\Components\TextInput::make('name.' . $lang)
                                ->label(__('attributes.name'))
                                ->required(),
                        ], 'pages.apply.create_study_field_help'),
                    ])
                    ->createOptionModalHeading(__('pages.apply.create_study_field'));
                /**
                 * BUDGET SECTION
                 */
            case 'amount_requested':
            case 'other_fundings':
            case 'total_expected_income':
            case 'total_expected_outcome':
                // If we have a helper text in translation, we use it
                $helperText = (__('pages.apply.' . $name . '_help') !== 'pages.apply.' . $name . '_help') ? __('pages.apply.' . $name . '_help') : null;

                return Forms\Components\TextInput::make($name)
                    ->label(__('attributes.' . $name))
                    ->helperText($helperText)
                    ->numeric()
                    ->default(0)
                    ->minValue(0)
                    ->step(0.01)
                    ->suffix('€')
                    ->columnSpan([
                        'default' => 1,
                        'sm'      => 2,
                        'lg'      => 2,
                    ]);
                /**
                 * FILES SECTION
                 */
            case 'applicationForm':
            case 'financialForm':
            case 'additionalInformation':
            case 'otherAttachments':
                $generalSettings = app(GeneralSettings::class);
                $field = AgapeForm::fileField($name)
                    ->acceptedFileTypes(MimeType::getByExtensionList($generalSettings->{'extensions' . ucfirst($name)} ?? ''))
                    ->columnSpanFull();
                if ($name === 'otherAttachments') {
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
            default:
                return null;
        }
    }

    public function getDynamicField(array $settings): ?Forms\Components\Field
    {
        $fieldClass = match ($settings['type']) {
            'text'     => Forms\Components\TextInput::class,
            'date'     => Forms\Components\DatePicker::class,
            'richtext' => Forms\Components\RichEditor::class,
            'textarea' => Forms\Components\Textarea::class,
            'checkbox' => Forms\Components\CheckboxList::class,
            'select'   => Forms\Components\Select::class,
            default    => null,
        };
        if ($fieldClass === null) {
            return null;
        }

        $field = $fieldClass::make($settings['slug'])
            ->label($settings['label'][app()->getLocale()])
            ->required($settings['required'] ?? false);

        if (in_array($settings['type'], ['text'])) {
            $field = $field->minValue($settings['minValue'] ?? null)
                ->maxValue($settings['maxValue'] ?? null);
        }

        if (in_array($settings['type'], ['date'])) {
            $field = $field->minDate($settings['minValue'] ?? null)
                ->maxDate($settings['maxValue'] ?? null);
        }

        // TODO : handle select and checkbox

        if ($settings['repeatable'] ?? false) {
            $field = Forms\Components\Repeater::make($settings['slug'])
                ->label($settings['label'][app()->getLocale()])
                ->addActionLabel('+')
                ->reorderable(false)
                ->simple($field)
                ->minItems($settings['minItems'] ?? null)
                ->maxItems($settings['maxItems'] ?? null);
        }

        return $field
            ->columnSpanFull();
    }
}
