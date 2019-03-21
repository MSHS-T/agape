<?php

namespace App;

use App\Observer\ProjectCallObserver;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class ProjectCall extends Model
{
    use SoftDeletes;

    public $fillable = [
        'type',
        'year',
        'title',
        'description',
        'application_start_date',
        'application_end_date',
        'evaluation_start_date',
        'evaluation_end_date',
        'number_of_experts',
        'number_of_documents',
        'number_of_keywords',
        'number_of_laboratories',
        'number_of_study_fields',
        'number_of_target_dates',
        'privacy_clause',
        'invite_email_fr',
        'invite_email_en',
        'help_experts',
        'help_candidates',
    ];

    protected $appends = array('typeLabel');

    protected $dates = ['deleted_at'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($call) {
            $call->creator_id = Auth::id();
        });
        static::addGlobalScope('creation_date', function (Builder $builder) {
            $builder->orderBy('created_at', 'desc');
        });
    }

    public function creator(){
        return $this->belongsTo('App\User', 'creator_id');
    }

    public function applications(){
        return $this->hasMany('App\Application', 'projectcall_id');
    }

    public function submittedApplications(){
        return $this->applications()->where('submitted_at', '!=', null);
    }

    public function getTypeLabelAttribute(){
        return \App\Enums\CallType::getKey($this->type);
    }

    public function toString(){
        return sprintf("%s (%d)", $this->typeLabel, $this->year);
    }
}
