<?php

namespace App\Livewire;

use App\Filament\Actions\PasswordButtonAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Facades\Filament;
use Illuminate\Support\Collection;
use Filament\Notifications\Notification;
use Filament\Actions\Contracts\HasActions;
use Jeffgreco13\FilamentBreezy\Livewire\TwoFactorAuthentication;
use Laravel\Fortify\Actions\ConfirmTwoFactorAuthentication;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;
use Laravel\Fortify\Actions\GenerateNewRecoveryCodes;

class FilamentProfileTwoFactor extends TwoFactorAuthentication
{
    public function enableAction(): Action
    {
        return PasswordButtonAction::make('enable')
            ->label(__('filament-breezy::default.profile.2fa.actions.enable'))
            ->action(function (EnableTwoFactorAuthentication $enableTwoFactorAuthentication) {
                $enableTwoFactorAuthentication($this->user);
                Notification::make()
                    ->success()
                    ->title(__('filament-breezy::default.profile.2fa.enabled.notify'))
                    ->send();
            });
    }

    public function disableAction(): Action
    {
        return PasswordButtonAction::make('disable')
            ->label(__('filament-breezy::default.profile.2fa.actions.disable'))
            ->color('primary')
            ->requiresConfirmation()
            ->action(function (DisableTwoFactorAuthentication $disableTwoFactorAuthentication) {
                $disableTwoFactorAuthentication($this->user);
                Notification::make()
                    ->warning()
                    ->title(__('filament-breezy::default.profile.2fa.disabling.notify'))
                    ->send();
            });
    }

    public function confirmAction(): Action
    {
        return Action::make('confirm')
            ->color('success')
            ->label(__('filament-breezy::default.profile.2fa.actions.confirm_finish'))
            ->modalWidth('sm')
            ->form([
                Forms\Components\TextInput::make('code')
                    ->label(__('filament-breezy::default.fields.2fa_code'))
                    ->placeholder('###-###')
                    ->required()
            ])
            ->action(function ($data, $action, $livewire, ConfirmTwoFactorAuthentication $confirmTwoFactorAuthentication) {
                $confirmTwoFactorAuthentication($this->user, $data['code']);
                Notification::make()
                    ->success()
                    ->title(__('filament-breezy::default.profile.2fa.confirmation.success_notification'))
                    ->send();
            });
    }

    public function regenerateCodesAction(): Action
    {
        return PasswordButtonAction::make('regenerateCodes')
            ->label(__('filament-breezy::default.profile.2fa.actions.regenerate_codes'))
            ->requiresConfirmation()
            ->action(function (GenerateNewRecoveryCodes $generateNewRecoveryCodes) {
                $generateNewRecoveryCodes($this->user);
                $this->showRecoveryCodes = true;
                Notification::make()
                    ->success()
                    ->title(__('filament-breezy::default.profile.2fa.regenerate_codes.notify'))
                    ->send();
            });
    }

    public function getRecoveryCodesProperty(): Collection
    {
        return collect($this->user->recoveryCodes());
    }


    public function getTwoFactorQrCode()
    {
        return $this->user->twoFactorQrCodeSvg();
    }

    public function toggleRecoveryCodes()
    {
        $this->showRecoveryCodes = !$this->showRecoveryCodes;
    }

    public function showRequiresTwoFactorAlert()
    {
        return filament('filament-breezy')->shouldForceTwoFactor();
    }
}
