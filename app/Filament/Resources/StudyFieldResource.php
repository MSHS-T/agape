<?php

namespace App\Filament\Resources;

use App\Filament\AgapeForm;
use App\Filament\AgapeTable;
use App\Filament\Resources\StudyFieldResource\Pages;
use App\Filament\Resources\StudyFieldResource\RelationManagers;
use App\Models\StudyField;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudyFieldResource extends Resource
{
    protected static ?string $model = StudyField::class;

    protected static ?string $navigationIcon = 'fas-graduation-cap';
    protected static ?int $navigationSort    = 20;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                AgapeForm::translatableFields($form, fn ($lang) => [
                    Forms\Components\TextInput::make('name.' . $lang)
                        ->label(__('attributes.name'))
                        ->required(),
                ]),
                AgapeForm::creatorField()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('attributes.name'))
                    ->sortable(),
                AgapeTable::creatorColumn()
                    ->label(__('attributes.owner')),
                ...AgapeTable::timestampColumns()
            ])
            ->filters([
                //
            ])
            ->actions([
                ...AgapeTable::makePublicAction(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListStudyFields::route('/'),
            'create' => Pages\CreateStudyField::route('/create'),
            'edit' => Pages\EditStudyField::route('/{record}/edit'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return __('resources.study_field_plural');
    }

    public static function getModelLabel(): string
    {
        return __('resources.study_field');
    }

    public static function getPluralModelLabel(): string
    {
        return __('resources.study_field_plural');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('admin.sections.data');
    }
}
