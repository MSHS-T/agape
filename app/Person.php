<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Person extends Model
{
    protected $table = "persons";

    protected $appends = array('name');

    public $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'status',
        'is_workshop'
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($call) {
            $call->creator_id = Auth::id();
        });
    }

    public function applications(){
        return $this->hasMany('App\Application');
    }

    public function getNameAttribute(){
        return ucfirst($this->first_name) . " " . strtoupper($this->last_name);
    }
}
