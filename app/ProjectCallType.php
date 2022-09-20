<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectCallType extends Model
{
    public $fillable = [
        'reference',
        'label_long',
        'label_short',
        'is_workshop'
    ];

    protected $casts = [
        'is_workshop' => 'boolean',
    ];
}
