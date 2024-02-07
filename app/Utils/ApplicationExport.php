<?php

namespace App\Utils;

use App\Models\Application;
use App\Models\Laboratory;
use App\Models\ProjectCall;
use App\Models\StudyField;
use App\Settings\GeneralSettings;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as DomPDF;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use NumberFormatter;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ApplicationExport
{
    protected ProjectCall $projectCall;

    public static function getPdf(string $viewName, array $data, bool $debug = false): DomPDF|View
    {
        if ($debug) {
            return view($viewName, [...$data, 'debug' => $debug]);
        } else {
            return Pdf::loadView($viewName, [...$data, 'debug' => $debug]);
        }
    }

    /**
     * Export a single application
     */
    public static function export(Application $application, bool $debug = false)
    {
        $title = implode(' - ', [
            config('app.name'),
            __('admin.application.export_name'),
            $application->reference,
        ]);

        $inst = new self($application);
        ray($inst->buildData());

        $data = [
            'application' => $application,
            'projectCall' => $application->projectCall,
            'data'        => $inst->buildData(),
        ];

        return [$title, self::getPdf('export.application', $data, $debug)];
    }

    public function __construct(protected Application $application)
    {
        $this->projectCall = $this->application->projectCall;
    }

    public function buildData(): array
    {
        return [
            [
                'title' => __('resources.project_call') . ' : ' . $this->projectCall->projectCallType->label_short . " - " . $this->projectCall->year,
                'fields' => [
                    [
                        'label' => __('attributes.reference'),
                        'value' => $this->application->reference
                    ],
                    [
                        'label' => __('attributes.submitted_at'),
                        'value' => $this->application->submitted_at->format(__('misc.datetime_format'))
                    ]
                ]
            ],
            self::buildSection('general'),
            self::buildSection('scientific'),
            self::buildSection('budget'),
            self::buildSection('files'),
        ];
    }

    public static function fieldsPerSection(): array
    {
        $generalSettings = app(GeneralSettings::class);
        $budgetFields = [
            'amount_requested'       => __('attributes.amount_requested'),
            'other_fundings'         => __('attributes.other_fundings'),
        ];
        if ($generalSettings->enableBudgetIncomeOutcome) {
            $budgetFields = array_merge(
                $budgetFields,
                [
                    'total_expected_income'  => __('attributes.total_expected_income'),
                    'total_expected_outcome' => __('attributes.total_expected_outcome'),
                ]
            );
        }

        return [
            'general'    => [
                'acronym'      => __('attributes.acronym'),
                'title'        => __('attributes.title'),
                'carrier'      => __('attributes.carrier'),
                'laboratories' => __('pages.apply.laboratories_partners'),
                'studyFields'  => __('resources.study_field_plural'),
                'keywords'     => __('attributes.keywords'),
            ],
            'scientific' => [
                'short_description' => __('attributes.short_description'),
                'summary.fr'        => __('attributes.summary_fr'),
                'summary.en'        => __('attributes.summary_en'),
            ],
            'budget'     => $budgetFields,
            'files'      => [
                'applicationForm'       => __('attributes.files.applicationForm'),
                'financialForm'         => __('attributes.files.financialForm'),
                'additionalInformation' => __('attributes.files.additionalInformation'),
                'otherAttachments'      => __('attributes.files.otherAttachments'),
            ]
        ];
    }

    public function buildSection(string $section): array
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
                [
                    'label' => $label,
                    'value' => $this->getFieldValue($fieldName)
                ],
                ...$dynamicFields
                    ->filter(fn ($field) => $field['after_field'] === $fieldName)
                    ->map(fn ($field) => [
                        'label' => $field['label'][app()->getLocale()],
                        'value' => $this->getDynamicFieldValue($field)
                    ])
                    ->all()
            );
        }
        $sectionFields->push(
            ...$dynamicFields
                ->filter(fn ($field) => !in_array($field['after_field'], array_keys($fieldsWithLabels)))
                ->map(fn ($field) => [
                    'label' => $field['label'][app()->getLocale()],
                    'value' => $this->getDynamicFieldValue($field)
                ])
                ->all()
        );

        $sectionFields = $sectionFields->filter(fn ($f) => $f !== null);

        return [
            'title'  => __('pages.apply.sections.' . $section),
            'fields' => $sectionFields->all()
        ];
    }

    public function getFieldValue(string $name): null|string|array
    {
        // Only fields with specific processing are in the switch cases, the rest is in the default case
        switch ($name) {
                /**
             * GENERAL SECTION
             */
            case 'carrier':
                return [
                    [
                        'label' => __('attributes.first_name'),
                        'value' => $this->application->carrier['first_name']
                    ],
                    [
                        'label' => __('attributes.last_name'),
                        'value' => $this->application->carrier['last_name']
                    ],
                    [
                        'label' => __('attributes.email'),
                        'value' => $this->application->carrier['email']
                    ],
                    [
                        'label' => __('attributes.phone'),
                        'value' => $this->application->carrier['phone']
                    ],
                    [
                        'label' => __('attributes.carrier_status'),
                        'value' => $this->application->carrier['status']
                    ],
                ];
            case 'laboratories':
                return $this->application->laboratories->map(fn (Laboratory $laboratory, int $index) => [
                    'label' => $index === 0 ? __('attributes.main_laboratory') : (__('resources.laboratory') . ' #' . ($index + 1)),
                    'value' => [
                        [
                            'label' => __('attributes.unit_code'),
                            'value' => $laboratory->unit_code,
                        ],
                        [
                            'label' => __('attributes.director_email'),
                            'value' => $laboratory->director_email,
                        ],
                        [
                            'label' => __('attributes.regency'),
                            'value' => $laboratory->regency,
                        ],
                        [
                            'label' => __('attributes.contact_name'),
                            'value' => $laboratory->pivot->contact_name,
                        ],
                    ]
                ])->toArray();
                /**
                 * SCIENTIFIC SECTION
                 */
            case 'summary.fr':
                return $this->application->getTranslation('summary', 'fr');
            case 'summary.en':
                return $this->application->getTranslation('summary', 'en');
            case 'studyFields':
                return $this->application->studyFields->map(fn (StudyField $studyField) => $studyField->name)->all();
                /**
                 * BUDGET SECTION
                 */
            case 'amount_requested':
            case 'other_fundings':
            case 'total_expected_income':
            case 'total_expected_outcome':
                return (new NumberFormatter(app()->getLocale(), NumberFormatter::CURRENCY))->formatCurrency($this->application->{$name}, "EUR");
                /**
                 * FILES SECTION
                 */
            case 'applicationForm':
            case 'financialForm':
            case 'additionalInformation':
            case 'otherAttachments':
                if ($name === 'otherAttachments' && $this->projectCall->extra_attributes->number_of_documents == 0) {
                    return null;
                }
                if (!$this->projectCall->hasMedia($name)) {
                    return null;
                }
                return $this->application->getMedia($name)->map(fn (Media $media) => $media->file_name)->all();
            default:
                return $this->application->{$name};
        }
    }

    public function getDynamicFieldValue(array $settings): null|string|array
    {
        $slug = $settings['slug'] ?? Str::slug($settings['label']['en']);
        $repeatable = $settings['repeatable'] ?? false;
        switch ($settings['type']) {
            case 'text':
            case 'richtext':
                return $repeatable
                    ? collect($this->application->extra_attributes->get($slug, null))
                    ->flatten()
                    ->values()
                    ->all()
                    : $this->application->extra_attributes->get($slug, null);
                break;
            case 'date':
                return $repeatable
                    ? collect($this->application->extra_attributes->get($slug, null))
                    ->flatten()
                    ->values()
                    ->filter()
                    ->map(fn ($value) => (new Carbon($value))->format(__('misc.date_format')))
                    ->all()
                    : (
                        $this->application->extra_attributes->get($slug, null) !== null
                        ? (new Carbon($this->application->extra_attributes->get($slug)))->format(__('misc.date_format'))
                        : null
                    );
            case 'select':
                $options = collect($settings['options'] ?? [])
                    ->mapWithKeys(fn ($o) => [$o['value'] => $o['label'][app()->getLocale()]])->toArray();
                return ($settings['multiple'] ?? false)
                    ? collect($this->application->extra_attributes->get($slug, null))
                    ->flatten()
                    ->values()
                    ->map(fn ($value) => $options[$value])
                    ->all()
                    : $options[$this->application->extra_attributes->get($slug, null)];
            case 'checkbox':
                $choices = collect($settings['choices'] ?? [])
                    ->mapWithKeys(fn ($o) => [$o['value'] => $o['label'][app()->getLocale()]])->toArray();
                return collect($this->application->extra_attributes->get($slug, null))
                    ->flatten()
                    ->values()
                    ->map(fn ($value) => $choices[$value])
                    ->all();
            default:
                return null;
        }
    }
}
