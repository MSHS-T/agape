<?php

namespace App\Filament\Resources\ProjectCallTypeResource\Pages;

use App\Filament\Resources\ProjectCallTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewProjectCallType extends ViewRecord
{
    protected static string $resource = ProjectCallTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
