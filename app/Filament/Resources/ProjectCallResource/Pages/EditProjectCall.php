<?php

namespace App\Filament\Resources\ProjectCallResource\Pages;

use App\Filament\Resources\ProjectCallResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditProjectCall extends EditRecord
{
    protected static string $resource = ProjectCallResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
