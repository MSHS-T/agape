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
        return $this->belongsTo('App\EvaluationOffer', 'offer_id');
    }

    public function toArray(){
        return [
            'grade1'         => $this->grade1,
            'grade2'         => $this->grade2,
            'grade3'         => $this->grade3,
            'global_grade'   => $this->global_grade,
            'comment1'       => $this->comment1,
            'comment2'       => $this->comment2,
            'comment3'       => $this->comment3,
            'global_comment' => $this->global_comment,
            'submitted_at'   => $this->submitted_at
        ];
    }
}
