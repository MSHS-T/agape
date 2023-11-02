<?php

namespace App\Filament\Resources\ProjectCallTypeResource\Pages;

use App\Filament\Resources\ProjectCallTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListProjectCallTypes extends ListRecords
{
    protected static string $resource = ProjectCallTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTitle(): string | Htmlable
    {
        return static::getResource()::getPluralModelLabel();
    }
}
