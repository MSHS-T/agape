<?php

namespace App\Filament\Resources\ProjectCallTypeResource\Pages;

use App\Filament\Resources\ProjectCallTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProjectCallType extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = ProjectCallTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            // ...
        ];
    }
}
