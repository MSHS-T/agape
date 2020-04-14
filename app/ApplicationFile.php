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

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($file) {
            unlink(base_path($file->filepath));
        });
        // static::creating(function($file){
        //     if(starts_with($file->filepath, 'public/uploads/')){
        //         $file->filepath = str_replace_first('public/uploads/', 'public/storage/uploads/', $file->filepath);
        //     }
        // });
    }

    public function application()
    {
        return $this->belongsTo('App\Application');
    }
}
