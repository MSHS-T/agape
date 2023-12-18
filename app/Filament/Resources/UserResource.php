<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\ProjectCallType;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use STS\FilamentImpersonate\Tables\Actions\Impersonate;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'fas-user-gear';
    protected static ?int $navigationSort    = 10;

    public static function form(Form $form): Form
    {
        $roles = Role::all()->pluck('name', 'id');
        $projectCallTypes = ProjectCallType::all()
            ->mapWithKeys(fn (ProjectCallType $projectCallType) => [$projectCallType->id => $projectCallType->label_short]);

        $isManager = fn ($roleValue) => $roleValue === 'manager';

        return $form
            ->schema([
                Forms\Components\TextInput::make('first_name')
                    ->label(__('attributes.first_name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('last_name')
                    ->label(__('attributes.last_name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label(__('attributes.email'))
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->label(__('attributes.phone'))
                    ->email()
                    ->maxLength(255),
                Forms\Components\Select::make('role')
                    // ->relationship('roles', 'name')
                    ->label(__('attributes.role'))
                    ->options($roles->mapWithKeys(fn ($r) => [$r => __('admin.roles.' . $r)]))
                    ->reactive(),
                Forms\Components\Select::make('projectCallTypes')
                    ->relationship('projectCallTypes', 'label_short')
                    ->label(__('attributes.managed_types'))
                    ->options($projectCallTypes)
                    ->multiple()
                    ->required(fn (Get $get) => $isManager($get('role')))
                    ->hidden(fn (Get $get) => !$isManager($get('role')))
                    // ->disabled(fn (Get $get) => !$isManager($get('roles')))
                    ->key('projectCallTypes'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('first_name')
                    ->label(__('attributes.first_name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->label(__('attributes.last_name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('roleName')
                    ->label(__('attributes.role'))
                    ->formatStateUsing(function (string $state, User $record) {
                        $suffix = '';
                        if ($record->roleName === 'manager') {
                            $projectCallTypes = $record->projectCallTypes->map(fn ($t) => $t->label_short)->join(' ; ');
                            $suffix = ' (' . $projectCallTypes . ')';
                        }
                        return Str::of(__('admin.roles.' . $state) . $suffix)
                            ->sanitizeHtml()
                            ->toHtmlString();
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'administrator' => 'danger',
                        'manager'       => 'warning',
                        'applicant'     => 'success',
                        'expert'        => 'info',
                        default         => 'gray',
                    }),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('attributes.email'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label(__('attributes.phone'))
                    ->searchable(),
                Tables\Columns\IconColumn::make('email_verified_at')
                    ->label(__('attributes.email_verified'))
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('last_active_at')
                    ->label(__('attributes.last_active_at'))
                    ->dateTime(__('misc.datetime_format'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('attributes.created_at'))
                    ->dateTime(__('misc.datetime_format'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make()
                    ->label(__('admin.users.blocked_filter'))
                    ->placeholder(__('admin.users.unblocked'))
                    ->trueLabel(__('admin.users.all'))
                    ->falseLabel(__('admin.users.blocked')),
                Tables\Filters\Filter::make('role_filter')
                    ->form([
                        Forms\Components\Select::make('role')
                            ->label(__('attributes.role'))
                            ->options(__('admin.roles'))
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            filled($data['role']),
                            fn (Builder $query): Builder => $query->role($data['role']),
                        );
                    })
            ], FiltersLayout::AboveContent)
            ->actions([
                Impersonate::make()
                    ->link()
                    ->label(__('admin.users.impersonate'))
                    ->hiddenLabel(false)
                    ->color(Color::Lime)
                    ->redirectTo(route('home'))
                    ->backTo(route('filament.admin.resources.users.index')), // <---
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->label(__('admin.users.block'))
                    ->icon('fas-times')
                    ->modalHeading(fn ($record) => __('admin.users.block') . ' ' . $table->getRecordTitle($record))
                    ->hidden(function (User $record) {
                        if ($record->id === Auth::id()) {
                            return true;
                        }
                        if ($record->hasRole('administrator') && Auth::user()->hasRole('manager')) {
                            return true;
                        }
                        return $record->trashed();
                    }),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make()
                    ->label(__('admin.users.unblock'))
                    ->modalHeading(fn ($record) => __('admin.users.unblock') . ' ' . $table->getRecordTitle($record)),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'edit'  => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getNavigationLabel(): string
    {
        return __('resources.user_plural');
    }

    public static function getModelLabel(): string
    {
        return __('resources.user');
    }

    public static function getPluralModelLabel(): string
    {
        return __('resources.user_plural');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('admin.sections.admin');
    }
}
