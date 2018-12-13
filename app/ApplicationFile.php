<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicationFile extends Model
{
    public $fillable = [
        'order',
        'name',
        'filepath'
    ];

    public function application(){
        return $this->belongsTo('App\Application');
    }
}
