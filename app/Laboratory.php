<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Laboratory extends Model
{
    protected $table = 'laboratory';
    protected $fillable = [
        'name',
        'unit_code',
        'director_email',
        'regency'
    ];

    public function applications(){
        return $this->belongsToMany('App\Application', 'application_laboratory', 'laboratory_id', 'application_id');
    }

    public function creator(){
        return $this->belongsTo('App\User', 'creator_id');
    }
}
