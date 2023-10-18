<?php

namespace App\Filament\Pages;

use App\Settings\GeneralSettings;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Infolists\Components\Split;
use Filament\Pages\SettingsPage;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Str;

class ManageGeneralSettings extends SettingsPage
{
    protected static ?string $navigationIcon = 'fas-cogs';
    protected static ?int $navigationSort    = 30;

    protected static string $settings = GeneralSettings::class;

    public static function getNavigationGroup(): ?string
    {
        return __('admin.sections.admin');
    }

    public static function getNavigationLabel(): string
    {
        return __('admin.settings.title');
    }

    public function getTitle(): string | Htmlable
    {
        return __('admin.settings.title');
    }

    public function form(Form $form): Form
    {
        $files = collect(['applicationForm', 'financialForm', 'additionalInformation', 'otherAttachments']);
        return $form
            ->columns(['sm' => 1, 'lg' => 3])
            ->schema([
                Section::make('projectCalls')
                    ->heading(__('admin.settings.sections.projectCalls'))
                    ->collapsible()
                    ->columns(1)
                    ->schema([
                        Fieldset::make('defaultNumbers')
                            ->label(__('admin.settings.sections.defaultNumbers'))
                            ->columns(['sm' => 1, 'lg' => 3])
                            ->schema([
                                TextInput::make('defaultNumberOfExperts')
                                    ->label(__('admin.settings.fields.defaultNumberOfExperts'))
                                    ->required()
                                    ->integer()
                                    ->minValue(1),
                                TextInput::make('defaultNumberOfDocuments')
                                    ->label(__('admin.settings.fields.defaultNumberOfDocuments'))
                                    ->required()
                                    ->integer()
                                    ->minValue(1),
                                TextInput::make('defaultNumberOfLaboratories')
                                    ->label(__('admin.settings.fields.defaultNumberOfLaboratories'))
                                    ->required()
                                    ->integer()
                                    ->minValue(1),
                                TextInput::make('defaultNumberOfStudyFields')
                                    ->label(__('admin.settings.fields.defaultNumberOfStudyFields'))
                                    ->required()
                                    ->integer()
                                    ->minValue(1),
                                TextInput::make('defaultNumberOfKeywords')
                                    ->label(__('admin.settings.fields.defaultNumberOfKeywords'))
                                    ->required()
                                    ->integer()
                                    ->minValue(1),
                            ]),
                        ...$files->map(fn ($fileName) => Fieldset::make($fileName)
                            ->label(__('admin.settings.fields.' . $fileName))
                            ->columns(['sm' => 1, 'md' => 2])
                            ->schema([
                                Toggle::make('enable' . ucfirst($fileName))
                                    ->label(__('admin.settings.fields.enable'))
                                    ->live(),
                                TextInput::make('extensions' . ucfirst($fileName))
                                    ->label(__('admin.settings.fields.extensions'))
                                    ->hidden(fn (Get $get) => !$get('enable' . ucfirst($fileName)))
                                    ->inlineLabel()
                                    ->required(fn (Get $get) => $get('enable' . ucfirst($fileName))),
                            ]))
                    ]),
                Section::make('grades')
                    ->heading(__('admin.settings.fields.grades'))
                    ->description(__('admin.settings.description.grades'))
                    ->collapsible()
                    ->columns(1)
                    ->schema([
                        Repeater::make('grades')
                            ->hiddenLabel()
                            ->addActionLabel(__('admin.settings.actions.addGrade'))
                            ->itemLabel(fn (array $state): ?string => $state['grade'] ?? null)
                            ->columns(['sm' => 1, 'md' => 3])
                            ->schema([
                                TextInput::make('grade')
                                    ->label(__('admin.settings.fields.gradeGrade'))
                                    ->columnSpan(['sm' => 'full', 'md' => 1])
                                    ->live()
                                    ->required(),
                                Fieldset::make('label')
                                    ->label(__('admin.settings.fields.gradeLabel'))
                                    ->columnSpan(['sm' => 'full', 'md' => 2])
                                    ->columns(min(3, count(config('agape.languages'))))
                                    ->schema(
                                        collect(config('agape.languages'))
                                            ->map(
                                                fn (string $lang) => TextInput::make('label.' . $lang)
                                                    ->label(Str::upper($lang))
                                                    ->validationAttribute(Str::upper($lang))
                                                    ->required()
                                            )
                                            ->all()
                                    )
                            ])
                    ]),
                Section::make('evaluation')
                    ->heading(__('admin.settings.fields.notation'))
                    ->description(__('admin.settings.description.notation'))
                    ->collapsible()
                    ->columns(1)
                    ->schema([
                        Repeater::make('notation')
                            ->hiddenLabel()
                            ->addActionLabel(__('admin.settings.actions.addNotation'))
                            ->itemLabel(fn (array $state): ?string => (($state['title'] ?? [])['fr']) ?? null)
                            ->columns(['sm' => 1])
                            ->collapsible()
                            ->collapsed()
                            ->schema([
                                Fieldset::make('title')
                                    ->label(__('admin.settings.fields.notationTitle'))
                                    ->columnSpan(['sm' => 'full', 'md' => 1])
                                    ->columns(min(3, count(config('agape.languages'))))
                                    ->schema(
                                        collect(config('agape.languages'))
                                            ->map(
                                                fn (string $lang) => TextInput::make('title.' . $lang)
                                                    ->label(Str::upper($lang))
                                                    ->validationAttribute(Str::upper($lang))
                                                    ->required()
                                            )
                                            ->all()
                                    ),
                                Fieldset::make('description')
                                    ->label(__('admin.settings.fields.notationDescription'))
                                    ->columnSpan(['sm' => 'full', 'md' => 1])
                                    ->columns(min(3, count(config('agape.languages'))))
                                    ->schema(
                                        collect(config('agape.languages'))
                                            ->map(
                                                fn (string $lang) => RichEditor::make('description.' . $lang)
                                                    ->label(Str::upper($lang))
                                                    ->validationAttribute(Str::upper($lang))
                                                    ->required()
                                                    ->toolbarButtons(['bold', 'italic', 'underline', 'strike', 'link', 'bulletList', 'orderedList'])
                                            )
                                            ->all()
                                    )
                            ])
                    ])
            ]);
    }
}
