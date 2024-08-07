<?php

namespace App\Policies;

use App\Models\ProjectCallType;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjectCallTypePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('administrator');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ProjectCallType $projectCallType): bool
    {
        return $user->hasRole('administrator');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('administrator');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ProjectCallType $projectCallType): bool
    {
        return $user->hasRole('administrator') && $projectCallType->canBeEdited();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ProjectCallType $projectCallType): bool
    {
        return $user->hasRole('administrator') && $projectCallType->projectCalls->isEmpty();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ProjectCallType $projectCallType): bool
    {
        return $user->hasRole('administrator');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ProjectCallType $projectCallType): bool
    {
        return $user->hasRole('administrator');
    }
}
