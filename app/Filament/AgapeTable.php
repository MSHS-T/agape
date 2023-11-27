<?php

namespace App\Filament;

use App\Models\Contracts\WithCreator;
use App\Models\Contracts\WithSubmission;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;

class AgapeTable
{
    /**
     * COLUMNS
     */
    public static function creatorColumn()
    {
        return TextColumn::make('creator_id')
            ->label(__('attributes.creator'))
            ->formatStateUsing(fn ($record) => filled($record->creator_id) ? $record->creator->name : __('admin.public'))
            ->sortable();
    }

    public static function submittedAtColumn()
    {
        return TextColumn::make('submitted_at')
            ->label(__('attributes.submitted_at'))
            ->dateTime(__('misc.datetime_format'))
            ->placeholder(__('admin.never'))
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: false);
    }

    public static function submissionStatusColumn()
    {
        return IconColumn::make('id')
            ->label(__('attributes.status'))
            ->icon(fn ($record): string => match (true) {
                filled($record->submitted_at)         => 'fas-check-circle',
                filled($record->devalidation_message) => 'fas-times-circle',
                default                               => 'fas-pen'
            })
            ->color(fn ($record): array => match (true) {
                filled($record->submitted_at)         => Color::Green,
                filled($record->devalidation_message) => Color::Red,
                default                               => Color::Orange
            })
            ->tooltip(fn ($record): string => match (true) {
                filled($record->submitted_at)         => __('admin.submission_status.submitted'),
                filled($record->devalidation_message) => __('admin.submission_status.devalidated'),
                default                               => __('admin.submission_status.draft')
            });
    }

    public static function timestampColumns(
        bool $withCreation = true,
        bool $withModification = true,
        bool $showCreation = false,
        bool $showModification = false,
        string $creationLabel = 'attributes.created_at',
        string $modificationLabel = 'attributes.updated_at'
    ) {
        return array_filter([
            $withCreation
                ? TextColumn::make('created_at')
                ->label(__($creationLabel))
                ->dateTime(__('misc.datetime_format'))
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: !$showCreation)
                : null,
            $withModification
                ? TextColumn::make('updated_at')
                ->label(__($modificationLabel))
                ->dateTime(__('misc.datetime_format'))
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: !$showModification)
                : null,
        ]);
    }

    /**
     * ACTIONS
     */

    public static function makePublicAction()
    {
        return Action::make('make_public')
            ->label(__('admin.make_public'))
            ->icon('fas-lock-open')
            ->color('warning')
            ->hidden(fn (WithCreator $record) => $record->creator_id === null)
            ->requiresConfirmation()
            ->action(fn (WithCreator $record) => $record->makePublic());
    }
    public static function submissionActions()
    {
        return [
            Action::make('unsubmit')
                ->label(__('admin.unsubmit'))
                ->icon('fas-delete-left')
                ->color(Color::Red)
                ->hidden(fn (WithSubmission $record) => !$record->canBeUnsubmitted())
                ->disabled(fn (WithSubmission $record) => !$record->canBeUnsubmitted())
                ->form([
                    AgapeForm::richTextEditor('devalidation_message')
                        ->label(__('attributes.devalidation_message'))
                        ->required(),
                ])
                ->modalSubmitActionLabel(__('admin.unsubmit'))
                ->modalFooterActionsAlignment(Alignment::Right)
                ->action(fn (array $data, WithSubmission $record) => $record->unsubmit($data['devalidation_message'])),
            Action::make('force_submit')
                ->label(__('admin.force_submit'))
                ->icon('fas-check-double')
                ->requiresConfirmation()
                ->color(Color::Amber)
                ->hidden(fn (WithSubmission $record) => filled($record->submitted_at))
                ->disabled(fn (WithSubmission $record) => filled($record->submitted_at))
                ->action(fn (WithSubmission $record) => $record->submit(force: true)),
        ];
    }
}
