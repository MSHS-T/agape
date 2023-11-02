<?php

namespace App\Filament\Resources\ProjectCallTypeResource\Pages;

use App\Filament\Resources\ProjectCallTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProjectCallType extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = ProjectCallTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
