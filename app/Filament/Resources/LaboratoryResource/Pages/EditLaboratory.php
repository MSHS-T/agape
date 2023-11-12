<?php

namespace App\Filament\Resources\LaboratoryResource\Pages;

use App\Filament\Resources\LaboratoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLaboratory extends EditRecord
{
    protected static string $resource = LaboratoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['public'] = blank($data['creator_id']);
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if ($data['public'] === true) {
            $data['creator_id'] = null;
        }
        return $data;
    }
}
