<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

    public function applications(){
        return $this->hasMany('App\Application');
    }

    public function getNameAttribute(){
        return ucfirst($this->first_name) . " " . strtoupper($this->last_name);
    }
}
