<?php

namespace App\Filament;

use Closure;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Form;
use Illuminate\Support\Str;

class AgapeForm
{
    public static function translatableFields(Form $form, Closure $fields): Tabs
    {
        return Tabs::make(__('admin.translatable_fields'))
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
}
