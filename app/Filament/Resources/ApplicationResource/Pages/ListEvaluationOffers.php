<?php

namespace App\Filament\Resources\ApplicationResource\Pages;

use App\Filament\AgapeTable;
use App\Filament\Resources\ApplicationResource;
use App\Models\Application;
use App\Models\EvaluationOffer;
use Filament\Actions;
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

class ListEvaluationOffers extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable {
        makeTable as makeBaseTable;
    }

    public Application $application;

    protected static string $resource = ApplicationResource::class;

    protected static string $view = 'filament.resources.application-resource.pages.list-evaluation-offers';

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
            ->query(fn (): Builder => EvaluationOffer::whereApplicationId($this->application->id))
            ->columns([
                Tables\Columns\TextColumn::make('expert.last_name')
                    ->label(__('admin.roles.expert'))
                    ->formatStateUsing(fn (EvaluationOffer $evaluationOffer) => $evaluationOffer->expert->name),
                Tables\Columns\IconColumn::make('accepted')
                    ->label(__('attributes.status'))
                    ->icon(fn (EvaluationOffer $record): string => match (true) {
                        $record->accepted === true  => 'fas-check-circle',
                        $record->accepted === false => 'fas-times-circle',
                        default                     => 'fas-hourglass'
                    })
                    ->color(fn (EvaluationOffer $record): array => match (true) {
                        $record->accepted === true  => Color::Green,
                        $record->accepted === false => Color::Red,
                        default                     => Color::Orange
                    })
                    ->tooltip(fn (EvaluationOffer $record): string => match (true) {
                        $record->accepted === true  => __('admin.evaluation_offer.status.accepted'),
                        $record->accepted === false => __('admin.evaluation_offer.status.rejected'),
                        default                     => __('admin.evaluation_offer.status.pending')
                    }),
                AgapeTable::creatorColumn(),
                ...AgapeTable::timestampColumns(withModification: false, showCreation: true),
                Tables\Columns\TextColumn::make('extra_attributes.retry_count')
                    ->label(__('admin.evaluation_offer.retries'))
                    ->formatStateUsing(
                        fn (EvaluationOffer $record) => Str::of(
                            collect($record->extra_attributes->retries ?? [])
                                ->pluck('at')
                                ->map(fn ($r) => (new Carbon($r))->format(__('misc.datetime_format')))
                                ->join('<br/>')
                        )->toHtmlString()
                    )
                    ->placeholder(__('admin.never')),
            ])
            ->filters([
                Tables\Filters\Filter::make('status')
                    ->form([
                        Forms\Components\Select::make('status')
                            ->label(__('attributes.status'))
                            ->options([
                                'accepted' => __('admin.evaluation_offer.status.accepted'),
                                'rejected' => __('admin.evaluation_offer.status.rejected'),
                                'pending'  => __('admin.evaluation_offer.status.pending')
                            ])->searchable()
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['status'] === 'accepted',
                                fn (Builder $query): Builder => $query->where('accepted', true),
                            )
                            ->when(
                                $data['status'] === 'rejected',
                                fn (Builder $query): Builder => $query->where('accepted', false),
                            )
                            ->when(
                                $data['status'] === 'pending',
                                fn (Builder $query): Builder => $query->whereNull('accepted'),
                            );
                    }),
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label(__('admin.evaluation_offer.show_reason'))
                    ->modalHeading(__('admin.evaluation_offer.rejection_title'))
                    ->modalContent(fn (EvaluationOffer $record) => view(
                        'components.filament.evaluation-offer-rejection-details',
                        ['record' => $record]
                    ))
                    ->modalFooterActionsAlignment(Alignment::Right)
                    ->hidden(fn (EvaluationOffer $record): bool => $record->accepted !== false),
                Tables\Actions\Action::make('retry')
                    ->label(__('admin.evaluation_offer.retry'))
                    ->color(Color::Indigo)
                    ->icon('fas-rotate-right')
                    ->requiresConfirmation()
                    ->action(fn (EvaluationOffer $record) => $record->retry())
                    ->hidden(fn (EvaluationOffer $record): bool => $record->accepted !== null),
                Tables\Actions\DeleteAction::make()
                    ->label(__('admin.evaluation_offer.cancel'))
                    ->hidden(fn (EvaluationOffer $record): bool => $record->accepted !== null),
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
            Action::make('evaluations')
                ->label(fn () => __('admin.application.evaluations', [
                    'count' => $this->application->evaluations->count()
                ]))
                ->url(fn () => route('filament.admin.resources.applications.evaluations', ['record' => $this->application]))
                ->color(Color::Green)
                ->icon('fas-file-signature')
        ];
    }

    public function getTitle(): string | Htmlable
    {
        return __('admin.evaluation_offer.list_title', ['application' => $this->application->reference]);
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
