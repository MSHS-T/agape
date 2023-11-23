<?php

namespace App\Filament\Resources;

use App\Filament\AgapeForm;
use App\Filament\AgapeTable;
use App\Filament\Resources\LaboratoryResource\Pages;
use App\Filament\Resources\LaboratoryResource\RelationManagers;
use App\Models\Laboratory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LaboratoryResource extends Resource
{
    protected static ?string $model = Laboratory::class;

    protected static ?string $navigationIcon = 'fas-flask-vial';
    protected static ?int $navigationSort    = 10;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('attributes.name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('unit_code')
                    ->label(__('attributes.unit_code'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('director_email')
                    ->label(__('attributes.director_email'))
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('regency')
                    ->label(__('attributes.regency'))
                    ->required()
                    ->maxLength(255),
                AgapeForm::creatorField()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('attributes.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('unit_code')
                    ->label(__('attributes.unit_code'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('director_email')
                    ->label(__('attributes.director_email'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('regency')
                    ->label(__('attributes.regency'))
                    ->searchable(),
                AgapeTable::creatorColumn(),
                ...AgapeTable::timestampColumns(),
            ])
            ->filters([
                //
            ])
            ->actions([
                // TODO : Make public action
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
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
            'index' => Pages\ListLaboratories::route('/'),
            'create' => Pages\CreateLaboratory::route('/create'),
            'edit' => Pages\EditLaboratory::route('/{record}/edit'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return __('resources.laboratory_plural');
    }

    public static function getModelLabel(): string
    {
        return __('resources.laboratory');
    }

    public static function getPluralModelLabel(): string
    {
        return __('resources.laboratory_plural');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('admin.sections.data');
    }
}
