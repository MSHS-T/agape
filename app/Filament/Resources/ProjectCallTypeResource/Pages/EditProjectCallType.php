<?php

namespace App\Filament\Resources\ProjectCallTypeResource\Pages;

use App\Filament\Resources\ProjectCallTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProjectCallType extends EditRecord
{
    protected static string $resource = ProjectCallTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
