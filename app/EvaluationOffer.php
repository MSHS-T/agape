<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluationOffer extends Model
{
    public $fillable = [
        'accepted',
        'justification'
    ];

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
        return $this->hasOne('App\Evaluation');
    }
}
