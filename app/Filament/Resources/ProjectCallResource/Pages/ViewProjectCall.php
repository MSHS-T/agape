<?php

namespace App\Filament\Resources\ProjectCallResource\Pages;

use App\Filament\Resources\ProjectCallResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewProjectCall extends ViewRecord
{
    protected static string $resource = ProjectCallResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
