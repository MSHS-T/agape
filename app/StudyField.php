<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class StudyField extends Model
{
    public $fillable = ['name'];

    public $timestamps = false;

    public static function boot()
    {
        parent::boot();
        static::creating(function ($sf) {
            $sf->creator_id = Auth::id();
        });
    }

    public function applications()
    {
        return $this->belongsToMany('App\Application');
    }

    public function creator()
    {
        return $this->belongsTo('App\User', 'creator_id');
    }

    public function scopeAccessible($query)
    {
        $users = User::admins()->get()->pluck('id')->toArray();
        array_push($users, Auth::id());
        return $query->whereIn('creator_id', $users);
    }
}
