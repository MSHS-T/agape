<?php

namespace App\Filament\Resources;

use App\Enums\ProjectCallStatus;
use App\Filament\AgapeForm;
use App\Filament\AgapeTable;
use App\Filament\Resources\ProjectCallResource\Pages;
use App\Models\ProjectCall;
use App\Settings\GeneralSettings;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ProjectCallResource extends Resource
{
    protected static ?string $model = ProjectCall::class;

    protected static ?string $navigationIcon = 'fas-bullhorn';

    public static function form(Form $form): Form
    {
        $generalSettings = app(GeneralSettings::class);
        $files = collect(['applicationForm', 'financialForm', 'additionalInformation'])
            ->filter(fn ($name) => $generalSettings->{'enable' . ucfirst($name)} ?? false);
        return $form
            ->columns([
                'default' => 1,
                'sm'      => 2,
                'lg'      => 4,
            ])
            ->schema([
                Forms\Components\Select::make('project_call_type_id')
                    ->label(__('attributes.project_call_type'))
                    ->columnSpan([
                        'default' => 1,
                        'sm'      => 1,
                        'lg'      => 2
                    ])
                    ->relationship('projectCallType', 'label_long->' . app()->getLocale())
                    ->required(),
                Forms\Components\TextInput::make('year')
                    ->label(__('attributes.year'))
                    ->columnSpan([
                        'default' => 1,
                        'sm'      => 1,
                        'lg'      => 2
                    ])
                    ->numeric()
                    ->minValue(2020)
                    ->step(1)
                    ->default(now()->format('Y'))
                    ->required(),
                Forms\Components\Section::make('dates')
                    ->heading(__('admin.dates'))
                    ->icon('fas-calendar')
                    ->columns([
                        'default' => 1,
                        'sm'      => 2,
                        'lg'      => 4,
                    ])
                    ->collapsible()
                    ->schema([
                        Forms\Components\DatePicker::make('application_start_date')
                            ->label(__('attributes.application_start_date'))
                            ->required(),
                        Forms\Components\DatePicker::make('application_end_date')
                            ->label(__('attributes.application_end_date'))
                            ->after('application_start_date')
                            ->required(),
                        Forms\Components\DatePicker::make('evaluation_start_date')
                            ->label(__('attributes.evaluation_start_date'))
                            ->after('application_end_date')
                            ->required(),
                        Forms\Components\DatePicker::make('evaluation_end_date')
                            ->label(__('attributes.evaluation_end_date'))
                            ->after('evaluation_start_date')
                            ->required(),
                    ]),
                AgapeForm::translatableFields($form, fn ($lang) => [
                    Forms\Components\TextInput::make('title.' . $lang)
                        ->label(__('attributes.title'))
                        ->columnSpanFull(),
                    Forms\Components\RichEditor::make('description.' . $lang)
                        ->label(__('attributes.description'))
                        ->columnSpanFull()
                        ->required(),
                    Forms\Components\RichEditor::make('privacy_clause.' . $lang)
                        ->label(__('attributes.privacy_clause'))
                        ->columnSpan([
                            'default' => 1,
                            'sm'      => 1,
                            'lg'      => 2
                        ])
                        ->required(),
                    Forms\Components\RichEditor::make('invite_email.' . $lang)
                        ->label(__('attributes.invite_email'))
                        ->columnSpan([
                            'default' => 1,
                            'sm'      => 1,
                            'lg'      => 2
                        ])
                        ->required(),
                    Forms\Components\RichEditor::make('help_experts.' . $lang)
                        ->label(__('attributes.help_experts'))
                        ->columnSpan([
                            'default' => 1,
                            'sm'      => 1,
                            'lg'      => 2
                        ])
                        ->required(),
                    Forms\Components\RichEditor::make('help_candidates.' . $lang)
                        ->label(__('attributes.help_candidates'))
                        ->columnSpan([
                            'default' => 1,
                            'sm'      => 1,
                            'lg'      => 2
                        ])
                        ->required(),
                ]),
                AgapeForm::notationSection(default: $generalSettings->notation)
                    ->collapsible()
                    ->description(__('admin.notation_description')),
                Forms\Components\Section::make('files')
                    ->heading(__('admin.files'))
                    ->description(__('admin.files_description'))
                    ->icon('fas-file-lines')
                    ->collapsible()
                    ->columns([
                        'default' => 1,
                        'sm'      => 2,
                        'lg'      => 3,
                    ])
                    ->schema(
                        $files
                            ->map(fn ($fileName) => AgapeForm::projectCallFileField($fileName))
                            ->all()
                    ),
                Forms\Components\Section::make('settings')
                    ->heading(__('admin.settings.title'))
                    ->icon('fas-cogs')
                    ->collapsible()
                    ->columns([
                        'default' => 1,
                        'sm'      => 2,
                        'lg'      => 4,
                    ])
                    ->schema([
                        Forms\Components\TextInput::make('extra_attributes.number_of_documents')
                            ->label(__('attributes.number_of_documents'))
                            ->default($generalSettings->defaultNumberOfDocuments)
                            ->required()
                            ->integer()
                            ->minValue(1),
                        Forms\Components\TextInput::make('extra_attributes.number_of_laboratories')
                            ->label(__('attributes.number_of_laboratories'))
                            ->default($generalSettings->defaultNumberOfLaboratories)
                            ->required()
                            ->integer()
                            ->minValue(1),
                        Forms\Components\TextInput::make('extra_attributes.number_of_study_fields')
                            ->label(__('attributes.number_of_study_fields'))
                            ->default($generalSettings->defaultNumberOfStudyFields)
                            ->required()
                            ->integer()
                            ->minValue(1),
                        Forms\Components\TextInput::make('extra_attributes.number_of_keywords')
                            ->label(__('attributes.number_of_keywords'))
                            ->default($generalSettings->defaultNumberOfKeywords)
                            ->required()
                            ->integer()
                            ->minValue(1),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('#')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('reference')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('year')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('attributes.status'))
                    ->badge()
                    ->color(fn (ProjectCallStatus $state) => $state->color())
                    ->formatStateUsing(fn (ProjectCallStatus $state): string => __($state->label()))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ViewColumn::make('application_start_date')
                    ->label(__('admin.dates'))
                    ->view('filament.tables.columns.projectcall-planning')
                    ->sortable(),
                Tables\Columns\TextColumn::make('applications_count')
                    ->counts('applications')
                    ->label(__('resources.application_plural'))
                    ->sortable(),
                AgapeTable::creatorColumn()
                    ->toggleable(isToggledHiddenByDefault: true),
                ...AgapeTable::timestampColumns()
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('year')
                    ->label(__('attributes.year'))
                    ->options(
                        ProjectCall::all()->pluck('year', 'year')->unique()->all()
                    ),
                Tables\Filters\SelectFilter::make('status')
                    ->label(__('attributes.status'))
                    ->options(
                        collect(ProjectCallStatus::cases())
                            ->mapWithKeys(fn (ProjectCallStatus $status) => [$status->value => __($status->label())])
                            ->all()
                    ),
                Tables\Filters\TrashedFilter::make()
                    ->label(__('admin.archived_records.label'))
                    ->trueLabel(__('admin.archived_records.with'))
                    ->falseLabel(__('admin.archived_records.only'))
                    ->placeholder(__('admin.archived_records.all'))
                    ->default(null)
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('id', 'desc');
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
            'index'  => Pages\ListProjectCalls::route('/'),
            'view'   => Pages\ViewProjectCall::route('/{record}'),
            'create' => Pages\CreateProjectCall::route('/create'),
            'edit'   => Pages\EditProjectCall::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getNavigationLabel(): string
    {
        return __('resources.project_call_plural');
    }

    public static function getModelLabel(): string
    {
        return __('resources.project_call');
    }

    public static function getPluralModelLabel(): string
    {
        return __('resources.project_call_plural');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('admin.sections.projectcalls');
    }
}