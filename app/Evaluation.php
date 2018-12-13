<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    public $fillable = [
        'grade1',
        'comment1',
        'grade2',
        'comment2',
        'grade3',
        'comment3',
        'global_grade',
        'global_comment',
        'submitted_at'
    ];

    public function offer(){
        return $this->hasOne('App\EvaluationOffer', 'offer_id');
    }
}
