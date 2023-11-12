<?php

namespace App\Models\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

trait HasCreator
{
    public function initializeHasCreator()
    {
        $this->casts['creator_id'] = 'int';
        $this->fillable[] = 'creator_id';
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id', 'id');
    }

    public static function bootHasCreator()
    {
        static::creating(function ($model) {
            if (blank($model->creator_id)) {
                $user = Auth::user();
                // Adds logged in user as creator
                $model->creator()->associate(
                    (App::runningInConsole() || $user->hasAnyRole(['administrator', 'manager']))
                        ? null
                        : Auth::user()
                );
            }
        });
    }

    /**
     * Scope a query to only include models created by the current user.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMine($query)
    {
        return $query->where('creator_id', Auth::id());
    }

    public function makePublic(): static
    {
        $this->creator()->dissociate();
        $this->save();
        return $this;
    }
}
