<?php

namespace App\Livewire;

use Filament\Forms;
use Jeffgreco13\FilamentBreezy\Livewire\PersonalInfo;

class FilamentProfilePersonalInfo extends PersonalInfo
{
    public array $only = ['first_name', 'last_name', 'email'];
    protected function getProfileFormSchema()
    {
        $first_name = Forms\Components\TextInput::make('first_name')
            ->required()
            ->label(__('attributes.first_name'));
        $last_name = Forms\Components\TextInput::make('last_name')
            ->required()
            ->label(__('attributes.last_name'));
        $email = Forms\Components\TextInput::make('email')
            ->required()
            ->email()
            ->unique($this->userClass, ignorable: $this->user)
            ->label(__('filament-breezy::default.fields.email'));

        return [
            Forms\Components\Group::make([
                $first_name,
                $last_name,
                $email
            ])->columnSpan(3)
        ];
    }
}
