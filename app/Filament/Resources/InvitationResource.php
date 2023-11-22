<?php

namespace App\Filament\Resources;

use App\Filament\AgapeTable;
use App\Filament\Resources\InvitationResource\Pages;
use App\Filament\Resources\InvitationResource\RelationManagers;
use App\Models\Invitation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InvitationResource extends Resource
{
    protected static ?string $model = Invitation::class;

    protected static ?string $navigationIcon = 'fas-envelope';
    protected static ?int $navigationSort    = 20;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('invitation')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('extra_attributes'),
                Forms\Components\Select::make('creator_id')
                    ->relationship('creator', 'id'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                AgapeTable::creatorColumn(),
                ...AgapeTable::timestampColumns(showCreation: true, showModification: true, modificationLabel: 'admin.invitations.last_mail'),
                Tables\Columns\TextColumn::make('extra_attributes.retry_count')
                    ->label(__('admin.invitations.retry_count'))
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('retry')
                    ->label(__('admin.invitations.retry'))
                    ->color(Color::Indigo)
                    ->icon('fas-rotate-right')
                    ->requiresConfirmation()
                    ->action(fn (Invitation $record) => $record->retry()),
                Tables\Actions\DeleteAction::make()
                    ->label(__('admin.invitations.cancel')),
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
            'index' => Pages\ListInvitations::route('/'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return __('resources.invitation_plural');
    }

    public static function getModelLabel(): string
    {
        return __('resources.invitation');
    }

    public static function getPluralModelLabel(): string
    {
        return __('admin.invitations.invitations_title');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('admin.sections.admin');
    }
}
