<?php

namespace App\Filament;

use App\Forms\Components\TitledTabs;
use App\Models\User;
use App\Settings\GeneralSettings;
use Closure;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AgapeForm
{
    public static function creatorField()
    {
        return Select::make('creator_id')
            ->label(__('attributes.creator'))
            ->relationship('creator', 'id')
            ->options(User::all()->pluck('name', 'id'))
            ->hidden(fn (Get $get) => $get('public'))
            ->required(fn (Get $get) => !$get('public'))
            ->disabled(fn (?Model $record) => $record !== null);
    }

    public static function projectCallFileField(string $fileName): SpatieMediaLibraryFileUpload
    {
        $generalSettings = app(GeneralSettings::class);
        return SpatieMediaLibraryFileUpload::make($fileName)
            ->label(__('attributes.files.' . $fileName))
            ->helperText(__('attributes.accepted_extensions', ['extensions' => $generalSettings->{'extensions' . ucfirst($fileName)}]))
            ->collection($fileName);
    }

    public static function translatableFields(Form $form, Closure $fields): TitledTabs
    {
        return TitledTabs::make('translatable_fields')
            ->heading(__('admin.translatable_fields.title'))
            ->description(__('admin.translatable_fields.description'))
            ->collapsible()
            ->icon('fas-language')
            ->columnSpanFull()
            ->columns($form->getColumnsConfig())
            ->tabs(
                collect(config('agape.languages'))->map(
                    fn ($lang) =>
                    Tabs\Tab::make(Str::upper($lang))
                        ->icon('flag-4x3-' . config('filament-language-switch.locales')[$lang]['flag_code'])
                        ->schema($fields($lang))
                )->all()
            );
    }

    public static function notationSection(array $default = []): Section
    {
        return Section::make('evaluation')
            ->heading(__('admin.settings.fields.notation'))
            ->icon('fas-pen-to-square')
            ->columns(1)
            ->schema([
                Repeater::make('notation')
                    ->hiddenLabel()
                    ->addActionLabel(__('admin.settings.actions.addNotation'))
                    ->itemLabel(fn (array $state): ?string => (($state['title'] ?? [])['fr']) ?? null)
                    ->columns(['sm' => 1])
                    ->default($default)
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
            ]);
    }
}
