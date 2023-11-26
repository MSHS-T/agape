<?php

namespace App\Filament;

use App\Models\EvaluationOffer;
use App\Models\ProjectCall;
use App\Models\StudyField;
use App\Settings\GeneralSettings;
use App\Utils\MimeType;
use Filament\Forms;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AgapeEvaluationForm
{
    public function __construct(protected EvaluationOffer $evaluationOffer, protected Forms\Form $form)
    {
    }

    public function buildForm(): array
    {
        $generalSettings = app(GeneralSettings::class);
        $grades = collect($generalSettings->grades);
        $notationGrid = $this->evaluationOffer->application->projectCall->notation;

        return [
            Forms\Components\Hidden::make('evaluation_offer_id')->default($this->evaluationOffer->id),
            ...collect($notationGrid)->map(
                fn ($section, $index) => Forms\Components\Section::make(Str::slug($section['title']['en']))
                    ->heading($section['title'][app()->getLocale()])
                    ->collapsible()
                    ->columnSpanFull()
                    ->schema([
                        Forms\Components\Placeholder::make('description')
                            ->label(Str::of(__('pages.evaluate.criteria_description'))->toHtmlString())
                            ->columnSpanFull()
                            ->content(
                                Str::of(
                                    '<div class="text-gray-700 dark:text-gray-200 prose prose-headings:text-gray-900 prose-headings:dark:text-white prose-a:text-gray-900 prose-a:dark:text-white prose-strong:text-gray-900 prose-strong:dark:text-white">'
                                        . ($section['description'][app()->getLocale()] ?? '')
                                        . '</div>'
                                )
                                    ->toHtmlString()
                            ),
                        Forms\Components\Radio::make('grades.' . $index)
                            ->label(__('pages.evaluate.grade'))
                            ->required()
                            ->options(
                                $grades
                                    ->mapWithKeys(fn ($grade) => [$grade['grade'] => $grade['grade'] . ' - ' . $grade['label'][app()->getLocale()]])
                                    ->toArray()
                            ),
                        AgapeForm::richTextEditor('comments.' . $index)
                            ->label(__('pages.evaluate.comment'))
                            ->required()
                            ->columnSpanFull()
                    ])
            ),
            Forms\Components\Radio::make('global_grade')
                ->label(__('pages.evaluate.global_grade'))
                ->required()
                ->options(
                    $grades
                        ->mapWithKeys(fn ($grade) => [$grade['grade'] => $grade['grade'] . ' - ' . $grade['label'][app()->getLocale()]])
                        ->toArray()
                ),
            AgapeForm::richTextEditor('global_comment')
                ->label(__('pages.evaluate.global_comment'))
                ->required()
                ->columnSpanFull()
        ];
    }
}
