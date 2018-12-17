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

    public static function get(string $key) {
        $row = self::find($key);
        return is_null($row) ? null : $row->value;
    }
}
