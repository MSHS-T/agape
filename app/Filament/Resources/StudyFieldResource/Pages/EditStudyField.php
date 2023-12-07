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
        if (($data['public'] ?? false) === true) {
            $data['creator_id'] = null;
        }
        return $data;
    }
}
