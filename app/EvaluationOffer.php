<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class EvaluationOffer extends Model
{
    public $fillable = [
        'accepted',
        'justification',
        'expert_id'
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($offer) {
            $offer->creator_id = Auth::id();
        });
    }

    public function creator(){
        return $this->belongsTo('App\User', 'creator_id');
    }

    public function expert(){
        return $this->belongsTo('App\User', 'expert_id');
    }

    public function application(){
        return $this->belongsTo('App\Application');
    }

    public function evaluation(){
        return $this->hasOne('App\Evaluation', 'offer_id');
    }
}
