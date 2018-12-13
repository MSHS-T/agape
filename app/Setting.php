<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $primaryKey = "key";
    public $incrementing = false;
    protected $keyType = "string";
    public $timestamps = false;

    public $fillable = ["key", "value"];
}
