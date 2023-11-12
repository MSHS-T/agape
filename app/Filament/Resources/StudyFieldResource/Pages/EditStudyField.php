<?php

namespace App\Filament\Resources\StudyFieldResource\Pages;

use App\Filament\Resources\StudyFieldResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStudyField extends EditRecord
{
    protected static string $resource = StudyFieldResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if ($data['public'] === true) {
            $data['creator_id'] = null;
        }
        return $data;
    }
}
