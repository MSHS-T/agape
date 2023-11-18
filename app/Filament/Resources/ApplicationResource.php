<?php

namespace App\Filament\Resources;

use App\Filament\AgapeForm;
use App\Filament\Resources\ApplicationResource\Pages;
use App\Filament\Resources\ApplicationResource\RelationManagers;
use App\Models\Application;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ApplicationResource extends Resource
{
    protected static ?string $model = Application::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('general')
                    ->heading(__('pages.apply.sections.general'))
                    ->collapsible()
                    ->columns([
                        'default' => 1,
                        'sm'      => 2,
                        'lg'      => 4,
                    ])
                    ->schema([
                        Forms\Components\TextInput::make('reference')
                            ->label(__('attributes.reference'))
                            ->disabled()
                            ->columnSpan([
                                'default' => 1,
                                'sm'      => 1,
                                'lg'      => 2,
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('acronym')
                            ->label(__('attributes.acronym'))
                            ->columnSpan([
                                'default' => 1,
                                'sm'      => 1,
                                'lg'      => 2,
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('title')
                            ->label(__('attributes.title'))
                            ->columnSpanFull()
                            ->required(),
                        Forms\Components\Fieldset::make(__('attributes.carrier'))
                            ->schema([
                                Forms\Components\TextInput::make('carrier.last_name')
                                    ->label(__('attributes.first_name'))
                                    ->default('')
                                    ->required(),
                                Forms\Components\TextInput::make('carrier.first_name')
                                    ->label(__('attributes.last_name'))
                                    ->default('')
                                    ->required(),
                                Forms\Components\TextInput::make('carrier.email')
                                    ->label(__('attributes.email'))
                                    ->default('')
                                    ->email()
                                    ->required(),
                                Forms\Components\TextInput::make('carrier.phone')
                                    ->label(__('attributes.phone'))
                                    ->default('')
                                    ->required(),
                                Forms\Components\TextInput::make('carrier.status')
                                    ->label(__('attributes.status'))
                                    ->default('')
                                    ->required(),
                            ]),
                        AgapeForm::richTextEditor('short_description')
                            ->label(__('attributes.short_description'))
                            ->columnSpanFull()
                            ->required(),
                        AgapeForm::richTextEditor('summary.fr')
                            ->label(__('attributes.summary_fr'))
                            ->columnSpan([
                                'default' => 1,
                                'sm'      => 1,
                                'lg'      => 2,
                            ])
                            ->required(),
                        AgapeForm::richTextEditor('summary.en')
                            ->label(__('attributes.summary_en'))
                            ->columnSpanFull()
                            ->columnSpan([
                                'default' => 1,
                                'sm'      => 1,
                                'lg'      => 2,
                            ])
                            ->required(),
                        Forms\Components\Repeater::make('applicationLaboratories')
                            ->label(__('resources.laboratory_plural'))
                            ->helperText(__('pages.apply.laboratories_help'))
                            ->relationship()
                            ->schema([
                                Forms\Components\Select::make('laboratory_id')
                                    ->label(false)
                                    ->relationship(name: 'laboratory', titleAttribute: 'name')
                                    ->searchable()
                                    ->preload()
                            ])
                            ->columnSpanFull()
                            ->grid([
                                'default' => 1,
                                'sm'      => 2,
                                'lg'      => 4,
                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListApplications::route('/'),
            'create' => Pages\CreateApplication::route('/create'),
            'view' => Pages\ViewApplication::route('/{record}'),
            'edit' => Pages\EditApplication::route('/{record}/edit'),
        ];
    }
}
