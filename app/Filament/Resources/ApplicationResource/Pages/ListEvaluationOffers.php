<?php

namespace App\Filament\Resources\ApplicationResource\Pages;

use App\Actions\InviteExpert;
use App\Actions\InviteUser;
use App\Filament\AgapeTable;
use App\Filament\Resources\ApplicationResource;
use App\Models\Application;
use App\Models\EvaluationOffer;
use App\Models\Invitation;
use App\Models\User;
use App\Tables\Columns\NullableIconColumn;
use Awcodes\Shout\Components\Shout;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
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
            ->query(fn(): Builder => EvaluationOffer::whereApplicationId($this->application->id))
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label(__('admin.roles.expert'))
                    ->formatStateUsing(
                        fn(EvaluationOffer $record) => (filled($record->expert) ? $record->expert?->name : $record->invitation?->email) ?? '?'
                    ),
                Tables\Columns\IconColumn::make('accepted')
                    ->label(__('attributes.status'))
                    ->getStateUsing(fn($record) => $record->accepted === null ? 'null' : $record->accepted)
                    ->icon(fn($state): string => match (true) {
                        $state === true  => 'fas-check-circle',
                        $state === false => 'fas-times-circle',
                        default          => 'fas-hourglass'
                    })
                    ->color(fn($state): array => match (true) {
                        $state === true  => Color::Green,
                        $state === false => Color::Red,
                        default          => Color::Orange
                    })
                    ->tooltip(fn($state): string => match (true) {
                        $state === true  => __('admin.evaluation_offer.status.accepted'),
                        $state === false => __('admin.evaluation_offer.status.rejected'),
                        default          => __('admin.evaluation_offer.status.pending')
                    })
                    ->alignCenter(),
                AgapeTable::creatorColumn(),
                ...AgapeTable::timestampColumns(withModification: false, showCreation: true),
                Tables\Columns\TextColumn::make('extra_attributes.retry_count')
                    ->label(__('admin.evaluation_offer.retries'))
                    ->formatStateUsing(
                        fn(EvaluationOffer $record) => Str::of(
                            collect($record->extra_attributes->retries ?? [])
                                ->pluck('at')
                                ->map(fn($r) => (new Carbon($r))->format(__('misc.datetime_format')))
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
                                fn(Builder $query): Builder => $query->where('accepted', true),
                            )
                            ->when(
                                $data['status'] === 'rejected',
                                fn(Builder $query): Builder => $query->where('accepted', false),
                            )
                            ->when(
                                $data['status'] === 'pending',
                                fn(Builder $query): Builder => $query->whereNull('accepted'),
                            );
                    }),
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label(__('admin.evaluation_offer.show_reason'))
                    ->modalHeading(__('admin.evaluation_offer.rejection_title'))
                    ->modalContent(fn(EvaluationOffer $record) => view(
                        'components.filament.evaluation-offer-rejection-details',
                        ['record' => $record]
                    ))
                    ->modalFooterActionsAlignment(Alignment::Right)
                    ->hidden(fn(EvaluationOffer $record): bool => $record->accepted !== false),
                Tables\Actions\Action::make('retry')
                    ->label(__('admin.evaluation_offer.retry'))
                    ->color(Color::Indigo)
                    ->icon('fas-rotate-right')
                    ->requiresConfirmation()
                    ->action(fn(EvaluationOffer $record) => $record->retry())
                    ->hidden(fn(EvaluationOffer $record): bool => $record->accepted !== null),
                Tables\Actions\Action::make('override')
                    ->label(__('admin.evaluation_offer.override'))
                    ->color(Color::Orange)
                    ->icon('fas-arrow-rotate-left')
                    ->requiresConfirmation()
                    ->action(function (EvaluationOffer $record) {
                        $record->accepted = null;
                        $record->save();
                    })
                    ->hidden(fn(EvaluationOffer $record): bool => $record->accepted === null || $record->evaluation !== null),
                Tables\Actions\DeleteAction::make()
                    ->label(__('admin.evaluation_offer.cancel'))
                    ->hidden(fn(EvaluationOffer $record): bool => $record->accepted !== null),
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
            Action::make('invite')
                ->label(__('admin.application.add_expert'))
                ->color(Color::Blue)
                ->icon('fas-user-plus')
                ->form([
                    Shout::make('invitation_info')
                        ->content(__('admin.evaluation_offer.invitation_info'))
                        ->icon('fas-info-circle')
                        ->color(Color::Cyan),
                    Select::make('expert_id')
                        ->label(__('admin.application.existing_expert'))
                        ->searchable()
                        ->options(User::role('expert')->get()->pluck('nameWithEmail', 'id'))
                        ->requiredWithout('invitation_email'),
                    Placeholder::make('separator')
                        ->hiddenLabel()
                        ->content(Str::of(view('components.separator', ['slot' => __('or')])->render())->toHtmlString()),
                    TextInput::make('invitation_email')
                        ->label(__('admin.application.new_expert'))
                        ->email()
                        ->requiredWithout('expert_id')
                ])
                ->action(function (array $data) {
                    InviteExpert::handle($this->application, $data['expert_id'], $data['invitation_email']);
                }),
            Action::make('evaluations')
                ->label(fn() => __('admin.application.evaluations', [
                    'count' => $this->application->evaluations->count()
                ]))
                ->url(fn() => route('filament.admin.resources.applications.evaluations', ['record' => $this->application]))
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
