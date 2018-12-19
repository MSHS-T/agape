<?php

namespace App;

use App\Observer\ProjectCallObserver;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class ProjectCall extends Model
{
    use SoftDeletes;

    public $fillable = [
        'type',
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
    ];

    protected $dates = ['deleted_at'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($call) {
            $call->creator_id = Auth::id();
        });
    }

    public function creator(){
        return $this->belongsTo('App\User', 'creator_id');
    }

    public function applications(){
        return $this->hasMany('App\Application');
    }
}
