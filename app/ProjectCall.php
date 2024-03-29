<?php

namespace App;

use App\Enums\CallType;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class ProjectCall extends Model
{
    use SoftDeletes;

    public $fillable = [
        'project_call_type_id',
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
        'application_form_filepath',
        'financial_form_filepath',
    ];

    protected $appends = array('evaluationCount');

    protected $dates = ['deleted_at'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($call) {
            $call->creator_id = Auth::id();

            $result = DB::table('project_calls')
                ->where('project_call_type_id', $call->project_call_type_id)
                ->where('year', $call->year)
                ->count();
            $call->reference = sprintf(
                "%s-%s-%s",
                substr(strval($call->year), -2),
                ProjectCallType::find($call->project_call_type_id)->reference,
                str_pad(strval(++$result), 2, "0", STR_PAD_LEFT)
            );
        });
        static::addGlobalScope('creation_date', function (Builder $builder) {
            $builder->orderBy('created_at', 'desc');
        });
    }

    public function type()
    {
        return $this->belongsTo('App\ProjectCallType', 'project_call_type_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo('App\User', 'creator_id');
    }

    public function applications()
    {
        return $this->hasMany('App\Application', 'projectcall_id');
    }

    public function submittedApplications()
    {
        return $this->applications()->where('submitted_at', '!=', null);
    }

    public function getTypeLabelAttribute()
    {
        return \App\Enums\CallType::getKey($this->type);
    }

    public function getEvaluationCountAttribute()
    {
        $cpt = 0;
        foreach ($this->submittedApplications as $application) {
            $submittedEvaluations = $application->evaluations->filter(function ($eval) {
                return !is_null($eval->submitted_at);
            });
            $cpt += count($submittedEvaluations);
        }
        return $cpt;
    }

    public function getStateAttribute()
    {
        if (\Carbon\Carbon::parse('today')->format('Y-m-d') <= $this->evaluation_end_date) {
            return "open";
        } else if ($this->trashed()) {
            return "archived";
        } else {
            return "closed";
        }
    }

    public function canApply()
    {
        $today = \Carbon\Carbon::parse('today')->format('Y-m-d');
        return $this->application_start_date <= $today && $today <= $this->application_end_date;
    }

    public function canEvaluate()
    {
        $today = \Carbon\Carbon::parse('today')->format('Y-m-d');
        return $this->evaluation_start_date <= $today && $today <= $this->evaluation_end_date;
    }

    public function scopeOpen($query)
    {
        return $query->where([
            ['application_start_date', '<=', \Carbon\Carbon::parse('today')->format('Y-m-d')],
            ['evaluation_end_date', '>=', \Carbon\Carbon::parse('today')->format('Y-m-d')]
        ]);
    }
    public function scopeMine($query)
    {
        $type_id = Auth::user()->role_type_id;
        return $query->where('project_call_type_id', '=', $type_id);
    }

    public function scopeOld($query)
    {
        return $query->where('evaluation_end_date', '<', \Carbon\Carbon::parse('today')->format('Y-m-d'));
    }

    public function scopeUserApplied($query)
    {
        return $query->whereHas('applications', function (Builder $query) {
            $query->where('applicant_id', '=', Auth::id())
                ->whereNotNull('submitted_at');
        });
    }

    public function scopeUserHasNotSubmitted($query)
    {
        return $query->whereHas('applications', function (Builder $query) {
            $query->where('applicant_id', '=', Auth::id())
                ->whereNull('submitted_at');
        });
    }

    public function toString()
    {
        return (sprintf("%s %d", $this->type->label_short, $this->year)
            . (!empty($this->title) ? " (" . $this->title . ")" : ""));
    }
}
