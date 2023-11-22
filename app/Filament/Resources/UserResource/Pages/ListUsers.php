<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Actions\InviteUser;
use App\Filament\Resources\UserResource;
use App\Models\Invitation;
use App\Models\ProjectCallType;
use App\Models\User;
use Filament\Actions;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Spatie\Permission\Models\Role;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        $roles = Role::all()->pluck('name');
        $projectCallTypes = ProjectCallType::all()
            ->mapWithKeys(fn (ProjectCallType $projectCallType) => [$projectCallType->id => $projectCallType->label_short]);

        $existingEmails = User::pluck('email')->concat(Invitation::pluck('email'))->flatten()->unique()->values();

        return [
            Actions\Action::make('invite_user')
                ->icon('fas-user-plus')
                ->label(__('admin.users.invite_user'))
                ->form([
                    Grid::make([
                        'default' => 1,
                        'sm' => 2,
                    ])
                        ->schema([
                            TextInput::make('email')
                                ->label(__('attributes.email'))
                                ->email()
                                ->required()
                                ->columnSpanFull()
                                ->maxLength(255)
                                ->notIn($existingEmails)
                                ->validationMessages([
                                    'not_in' => __('admin.users.invitation_duplicate_email')
                                ]),
                            Select::make('lang')
                                ->label(__('admin.users.invitation_language'))
                                ->options(
                                    collect(config('agape.languages'))
                                        ->mapWithKeys(fn ($l) => [$l => __('misc.locales.' . $l)])
                                )
                                ->required()
                                ->default(app()->getLocale())
                                ->selectablePlaceholder(false),
                            Select::make('role')
                                ->label(__('attributes.role'))
                                ->options($roles->mapWithKeys(fn ($r) => [$r => __('admin.roles.' . $r)]))
                                ->required()
                                ->reactive(),
                            Select::make('projectCallTypes')
                                ->label(__('attributes.managed_types'))
                                ->options($projectCallTypes)
                                ->columnSpanFull()
                                ->multiple()
                                ->required(fn (Get $get) => ($get('role') === 'manager'))
                                ->hidden(fn (Get $get) => !($get('role') === 'manager'))
                                ->key('projectCallTypes'),
                        ])
                ])
                ->action(function (array $data) {
                    try {
                        $invitation = InviteUser::handle($data['email'], $data['role'], $data['projectCallTypes'] ?? [], $data['lang'] ?? null);
                        if (!($invitation instanceof Invitation)) {
                            throw new \Exception("Unknown error");
                        }
                        Notification::make()
                            ->title(__('admin.users.invitation_success'))
                            ->success()
                            ->send();
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title(__('admin.users.invitation_error'))
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                })
        ];
    }
}
