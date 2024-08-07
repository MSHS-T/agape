<?php

namespace App\Filament\Resources\ApplicationResource\Pages;

use App\Filament\AgapeTable;
use App\Filament\Resources\ApplicationResource;
use App\Models\Application;
use App\Models\Evaluation;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\Page;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ListEvaluations extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable {
        makeTable as makeBaseTable;
    }

    public Application $application;

    protected static string $resource = ApplicationResource::class;

    protected static string $view = 'filament.resources.application-resource.pages.list-evaluations';

    public function mount(Application $record): void
    {
        $this->authorizeAccess();

        // $this->loadDefaultActiveTab();
        $this->application = $record;
    }

    protected function authorizeAccess(): void
    {
        static::authorizeResourceAccess();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Evaluation::whereHas('evaluationOffer', fn (Builder $query) => $query->whereApplicationId($this->application->id)))
            ->columns([
                Tables\Columns\TextColumn::make('evaluationOffer.expert.last_name')
                    ->label(__('admin.roles.expert'))
                    ->formatStateUsing(fn (Evaluation $evaluation) => $evaluation->evaluationOffer->expert->name),
                AgapeTable::submissionStatusColumn(),
                Tables\Columns\TextColumn::make('grades')
                    ->label(__('admin.evaluation.grades')),
                Tables\Columns\TextColumn::make('global_grade')
                    ->label(__('pages.evaluate.global_grade'))
                    ->sortable(),
                ...AgapeTable::timestampColumns(showModification: true),
                AgapeTable::submittedAtColumn(),
            ])
            ->filters([
                Tables\Filters\Filter::make('status')
                    ->form([
                        Forms\Components\Select::make('status')
                            ->label(__('attributes.status'))
                            ->options([
                                'draft'       => __('admin.submission_status.draft'),
                                'submitted'   => __('admin.submission_status.submitted'),
                                'devalidated' => __('admin.submission_status.devalidated'),
                            ])->searchable()
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['status'] === 'draft',
                                fn (Builder $query): Builder => $query->whereNull('submitted_at')->whereNull('devalidation_message'),
                            )
                            ->when(
                                $data['status'] === 'submitted',
                                fn (Builder $query): Builder => $query->whereNotNull('submitted_at'),
                            )
                            ->when(
                                $data['status'] === 'devalidated',
                                fn (Builder $query): Builder => $query->whereNull('submitted_at')->whereNotNull('devalidation_message'),
                            );
                    }),
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->modalHeading(fn (Evaluation $record) => __('admin.evaluation.show_title', [
                        'application' => $this->application->reference,
                        'expert'      => $record->evaluationOffer->expert->name,
                    ]))
                    ->modalContent(fn (Evaluation $record) => view(
                        'components.filament.evaluation-details',
                        ['record' => $record]
                    ))
                    ->modalFooterActionsAlignment(Alignment::Right),
                Tables\Actions\Action::make('retry')
                    ->label(__('admin.evaluation.retry'))
                    ->color(Color::Indigo)
                    ->icon('fas-rotate-right')
                    ->requiresConfirmation()
                    ->action(fn (Evaluation $record) => $record->retry())
                    ->hidden(fn (Evaluation $record): bool => $record->submitted_at !== null),
                ...AgapeTable::submissionActions(),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('export_evaluation')
                        ->label(__('admin.pdf_export'))
                        ->color(Color::Indigo)
                        ->icon('fas-file-pdf')
                        ->url(fn (Evaluation $record) => route('export_evaluation.evaluation', ['evaluation' => $record]))
                        ->openUrlInNewTab(),
                    Tables\Actions\Action::make('export_evaluation_anonymous')
                        ->label(__('admin.pdf_export_anonymous'))
                        ->color(Color::Indigo)
                        ->icon('fas-file-pdf')
                        ->url(fn (Evaluation $record) => route('export_evaluation.evaluation', ['evaluation' => $record, 'anonymized' => true]))
                        ->openUrlInNewTab(),
                ])
                    ->hidden(fn (Evaluation $record) => blank($record->submitted_at)),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // TODO : bulk retry
                    // TODO : bulk cancel
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('evaluationOffers')
                ->label(fn () => __('admin.application.offers', [
                    'count' => $this->application->evaluationOffers->count()
                ]))
                ->url(fn () => route('filament.admin.resources.applications.offers', ['record' => $this->application]))
                ->color(Color::Lime)
                ->icon('fas-user-tie')
        ];
    }

    public function getTitle(): string | Htmlable
    {
        return __('admin.evaluation.list_title', ['application' => $this->application->reference]);
    }

    /**
     * @return array<string>
     */
    public function getBreadcrumbs(): array
    {
        $resource = static::getResource();

        $breadcrumb = $this->getBreadcrumb();

        // ray(request()->rou('record'));

        return [
            $resource::getUrl() => $resource::getBreadcrumb(),
            ...(filled($breadcrumb) ? [$breadcrumb] : []),
        ];
    }
}
