<?php

namespace App\Filament\Resources\StudyFieldResource\Pages;

use App\Filament\Resources\StudyFieldResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStudyFields extends ListRecords
{
    protected static string $resource = StudyFieldResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
