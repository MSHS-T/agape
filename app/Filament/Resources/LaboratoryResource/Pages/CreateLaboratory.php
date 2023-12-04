<?php

namespace App\Filament\Resources\LaboratoryResource\Pages;

use App\Filament\Resources\LaboratoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLaboratory extends CreateRecord
{
    protected static string $resource = LaboratoryResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (($data['public'] ?? false) === true) {
            $data['creator_id'] = null;
        }
        return $data;
    }
}
