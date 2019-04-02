<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Invitation extends Model
{
    use Notifiable;

    protected $primaryKey = "invitation";
    protected $keyType = "string";
    public $incrementing = false;

    public $fillable = [
        'invitation',
        'email',
        'role'
    ];
}
