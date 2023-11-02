<?php

namespace App\Models\Traits;

use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

trait HasCreator
{
    public function initializeHasCreator()
    {
        $this->casts['creator_id'] = 'int';
        $this->fillable[] = 'creator_id';
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id', 'id');
    }

    public static function bootHasCreator()
    {
        static::creating(function ($model) {
            if (blank($model->creator_id)) {
                // Adds logged in user as creator
                $model->creator()->associate(
                    App::runningInConsole()
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
}