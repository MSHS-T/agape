<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudyField extends Model
{
    public $fillable = ['name'];

    public $timestamps = false;

    public function applications(){
        return $this->belongsToMany('App\Application');
    }
}
