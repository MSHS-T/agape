<?php

namespace App\Filament;

use App\Models\User;
use Closure;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
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
