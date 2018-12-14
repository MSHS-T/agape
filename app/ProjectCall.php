<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectCall extends Model
{
    public $fillable = [
        'type',
        'name',
        'year',
        'description',
        'application_start_date',
        'application_end_date',
        'evaluation_start_date',
        'evaluation_end_date',
        'number_of_experts',
        'number_of_documents',
        'privacy_clause',
        'invite_email_fr',
        'invite_email_en',
        'help_experts',
        'help_candidates',
        'closed'
    ];

    public function creator(){
        return $this->belongsTo('App\User', 'creator_id');
    }

    public function applications(){
        return $this->hasMany('App\Application');
    }
}
