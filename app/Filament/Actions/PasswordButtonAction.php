<?php

namespace App\Filament\Actions;

use Filament\Forms;
use Filament\Actions\Action;
use Jeffgreco13\FilamentBreezy\Actions\PasswordButtonAction as BreezyPasswordButtonAction;

class PasswordButtonAction extends BreezyPasswordButtonAction
{
    protected function setUp(): void
    {
        // session()->forget('auth.password_confirmed_at');
        parent::setUp();
        if (!$this->isPasswordSessionValid()) {
            // Require password confirmation
            $this->requiresConfirmation()
                ->modalHeading(__('misc.password_confirm.heading'))
                ->modalDescription(
                    __('misc.password_confirm.description')
                )
                ->form([
                    Forms\Components\TextInput::make("current_password")
                        ->label(__('misc.password_confirm.current_password'))
                        ->required()
                        ->password()
                        ->rule("current_password"),
                ]);
        }
    }
}
