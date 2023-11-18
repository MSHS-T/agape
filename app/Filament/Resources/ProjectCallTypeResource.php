<?php

namespace App\Filament\Resources;

use App\Filament\AgapeApplicationForm;
use App\Filament\AgapeForm;
use App\Filament\AgapeTable;
use App\Filament\Resources\ProjectCallTypeResource\Pages;
use App\Models\ProjectCallType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProjectCallTypeResource extends Resource
{
    protected static ?string $model = ProjectCallType::class;

    protected static ?string $navigationIcon = 'fas-tags';
    protected static ?int $navigationSort    = 50;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('reference')
                    ->label(__('attributes.reference'))
                    ->required()
                    ->maxLength(255),
                AgapeForm::translatableFields($form, fn ($lang) => [
                    Forms\Components\TextInput::make('label_long.' . $lang)
                        ->label(__('attributes.label_long'))
                        ->required(),
                    Forms\Components\TextInput::make('label_short.' . $lang)
                        ->label(__('attributes.label_short'))
                        ->required(),
                ]),
                Forms\Components\Repeater::make('dynamic_attributes')
                    ->label(__('attributes.dynamic_attributes.title'))
                    ->addActionLabel(__('admin.dynamic_attributes.create'))
                    ->columnSpanFull()
                    ->itemLabel(fn (array $state) => $state['label']['fr'] ?? $state['label']['en'] ?? '?')
                    ->reorderable()
                    ->reorderableWithButtons()
                    ->reorderableWithDragAndDrop(false)
                    ->collapsible()
                    ->schema([
                        Forms\Components\Hidden::make('slug')
                            ->disabled()
                            ->required(),
                        Forms\Components\Fieldset::make('label')
                            ->label(__('attributes.dynamic_attributes.label'))
                            ->columnSpan(['sm' => 'full', 'md' => 2])
                            ->columns(min(3, count(config('agape.languages'))))
                            ->schema(
                                collect(config('agape.languages'))
                                    ->map(
                                        fn (string $lang) => Forms\Components\TextInput::make('label.' . $lang)
                                            ->label(Str::upper($lang))
                                            ->live()
                                            ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug($state)))
                                            ->validationAttribute(Str::upper($lang))
                                            ->required()
                                    )
                                    ->all()
                            ),
                        Forms\Components\Fieldset::make('location')
                            ->label(__('attributes.dynamic_attributes.location'))
                            ->columnSpan(['sm' => 'full', 'md' => 2])
                            ->columns(min(3, count(config('agape.languages'))))
                            ->schema([
                                Forms\Components\Select::make('section')
                                    ->label(__('attributes.dynamic_attributes.section'))
                                    ->options(__('pages.apply.sections'))
                                    ->live()
                                    ->required(),
                                Forms\Components\Select::make('after_field')
                                    ->label(__('attributes.dynamic_attributes.after_field'))
                                    ->helperText(__('admin.dynamic_attributes.after_field_help'))
                                    ->options(fn (Get $get) => AgapeApplicationForm::fieldsPerSection()[$get('section')])
                                    ->default('')
                                    ->live()
                                    ->required(false)
                            ]),
                        Forms\Components\Radio::make('type')
                            ->label(__('attributes.dynamic_attributes.type') . ' : ')
                            ->options(__('attributes.dynamic_attributes.types'))
                            ->inline()
                            ->columnSpanFull()
                            ->live(),
                        // TODO : Options for select and checkboxes
                        // TODO : Rules
                        // TODO : Repeatable
                    ])
                    ->columns([
                        'default' => 1,
                        'sm'      => 2,
                        'lg'      => 4,
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('reference')
                    ->label(__('attributes.reference'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('label_short')
                    ->label(__('attributes.label_short'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('label_long')
                    ->label(__('attributes.label_long'))
                    ->searchable(),
                // TODO : count project calls and link to filtered list
                ...AgapeTable::timestampColumns()
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index'  => Pages\ListProjectCallTypes::route('/'),
            'create' => Pages\CreateProjectCallType::route('/create'),
            'edit'   => Pages\EditProjectCallType::route('/{record}/edit'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return __('resources.project_call_type_plural');
    }

    public static function getModelLabel(): string
    {
        return __('resources.project_call_type');
    }

    public static function getPluralModelLabel(): string
    {
        return __('resources.project_call_type_plural');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('admin.sections.projectcalls');
    }
}
