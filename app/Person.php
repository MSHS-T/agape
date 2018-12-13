<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    public $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'status',
        'type'
    ];

    public function applications(){
        return $this->hasMany('App\Application');
    }
}
