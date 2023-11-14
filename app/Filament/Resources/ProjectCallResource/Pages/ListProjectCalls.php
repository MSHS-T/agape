<?php

namespace App\Filament\Resources\ProjectCallResource\Pages;

use App\Filament\Resources\ProjectCallResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProjectCalls extends ListRecords
{
    protected static string $resource = ProjectCallResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
