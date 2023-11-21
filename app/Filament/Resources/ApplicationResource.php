<?php

namespace App\Filament\Resources;

use App\Filament\AgapeApplicationForm;
use App\Filament\AgapeForm;
use App\Filament\AgapeTable;
use App\Filament\Resources\ApplicationResource\Pages;
use App\Filament\Resources\ApplicationResource\RelationManagers;
use App\Models\Application;
use App\Models\ProjectCall;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ApplicationResource extends Resource
{
    protected static ?string $model = Application::class;

    protected static ?string $navigationIcon = 'fas-file-lines';
    protected static ?int $navigationSort    = 20;

    public static function form(Form $form): Form
    {
        return $form->schema([
            ...(new AgapeApplicationForm($form->getRecord()->projectCall, $form))
                ->buildForm()
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('projectCall.reference')
                    ->label(__('resources.project_call'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reference')
                    ->label(__('attributes.reference'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('creator.last_name')
                    ->label(__('admin.roles.applicant'))
                    ->formatStateUsing(fn (Application $application) => $application->creator->name),
                Tables\Columns\TextColumn::make('acronym')
                    ->label(__('attributes.acronym'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('laboratories.0.name')
                    ->label(__('attributes.main_laboratory'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('id')
                    ->label(__('attributes.status'))
                    ->icon(fn (Application $record): string => match (true) {
                        filled($record->submitted_at)         => 'fas-check-circle',
                        filled($record->devalidation_message) => 'fas-times-circle',
                        default                               => 'fas-pen'
                    })
                    ->color(fn (Application $record): array => match (true) {
                        filled($record->submitted_at)         => Color::Green,
                        filled($record->devalidation_message) => Color::Red,
                        default                               => Color::Gray
                    })
                    ->tooltip(fn (Application $record): string => match (true) {
                        filled($record->submitted_at)         => __('admin.application.status.submitted'),
                        filled($record->devalidation_message) => __('admin.application.status.devalidated'),
                        default                               => __('admin.application.status.draft')
                    }),
                ...AgapeTable::timestampColumns(showModification: true),
                Tables\Columns\TextColumn::make('submitted_at')
                    ->label(__('attributes.submitted_at'))
                    ->dateTime(__('misc.datetime_format'))
                    ->placeholder(__('admin.never'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('project_call_id')
                    ->label(__('resources.project_call'))
                    ->options(
                        ProjectCall::all()->pluck('reference', 'id')->unique()->all()
                    ),
                Tables\Filters\SelectFilter::make('creator_id')
                    ->label(__('admin.roles.applicant'))
                    ->options(
                        User::all()->pluck('name', 'id')->unique()->all()
                    )->searchable(),
                Tables\Filters\Filter::make('status')
                    ->form([
                        Forms\Components\Select::make('status')
                            ->label(__('attributes.status'))
                            ->options([
                                'draft'       => __('admin.application.status.draft'),
                                'submitted'   => __('admin.application.status.submitted'),
                                'devalidated' => __('admin.application.status.devalidated'),
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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('unsubmit')
                    ->label(__('admin.application.unsubmit'))
                    ->icon('fas-delete-left')
                    ->color(Color::Red)
                    ->hidden(fn (Application $record) => blank($record->submitted_at))
                    ->disabled(fn (Application $record) => blank($record->submitted_at))
                    ->form([
                        AgapeForm::richTextEditor('devalidation_message')
                            ->label(__('attributes.devalidation_message'))
                            ->required(),
                    ])
                    ->modalSubmitActionLabel(__('admin.application.unsubmit'))
                    ->modalFooterActionsAlignment(Alignment::Right)
                    ->action(fn (array $data, Application $record) => $record->update([
                        'devalidation_message' => $data['devalidation_message'],
                        'submitted_at'         => null,
                    ])),
                Tables\Actions\Action::make('force_submit')
                    ->label(__('admin.application.force_submit'))
                    ->icon('fas-check-double')
                    ->requiresConfirmation()
                    ->color(Color::Lime)
                    ->hidden(fn (Application $record) => filled($record->submitted_at))
                    ->disabled(fn (Application $record) => filled($record->submitted_at))
                    ->action(fn (Application $record) => $record->touch('submitted_at')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListApplications::route('/'),
            'view' => Pages\ViewApplication::route('/{record}'),
            'edit' => Pages\EditApplication::route('/{record}/edit'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return __('resources.application_plural');
    }

    public static function getModelLabel(): string
    {
        return __('resources.application');
    }

    public static function getPluralModelLabel(): string
    {
        return __('resources.application_plural');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('admin.sections.projectcalls');
    }
}
