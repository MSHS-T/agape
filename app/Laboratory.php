<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Laboratory extends Model
{
    protected $table = 'laboratories';
    protected $fillable = [
        'name',
        'unit_code',
        'director_email',
        'regency',
        'creator_id'
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($call) {
            $call->creator_id = Auth::id();
        });
    }

    public function applications(){
        return $this->belongsToMany('App\Application', 'application_laboratory', 'laboratory_id', 'application_id')->withPivot('order');
    }

    public function creator(){
        return $this->belongsTo('App\User', 'creator_id');
    }
}
