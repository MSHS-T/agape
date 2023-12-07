<?php

namespace App\Filament\Resources\StudyFieldResource\Pages;

use App\Filament\Resources\StudyFieldResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateStudyField extends CreateRecord
{
    protected static string $resource = StudyFieldResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (($data['public'] ?? false) === true) {
            $data['creator_id'] = null;
        }
        return $data;
    }
}
