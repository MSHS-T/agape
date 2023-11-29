<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use App\Notifications\UserRoleChange;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Role;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['role'] = User::find($data['id'])->roleName;

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        /** @var User $record */
        $oldRole = $record->roleName;

        $record->update(Arr::except($data, ['role']));

        if ($data['role'] !== 'manager') {
            $record->projectCallTypes()->detach();
        }
        $record->syncRoles($data['role']);
        if ($data['role'] !== $oldRole) {
            $record->notify(new UserRoleChange($record));
        }

        return $record;
    }
}
