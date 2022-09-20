<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Application extends Model
{
    protected $with = ['projectcall', 'carrier', 'laboratories', 'studyFields', 'files'];

    public $fillable = [
        'title',
        'acronym',
        'applicant_id',
        'other_laboratories',
        'duration',
        'target_date',
        'theme',
        'summary_fr',
        'summary_en',
        'keywords',
        'short_description',
        'amount_requested',
        'other_fundings',
        'total_expected_income',
        'total_expected_outcome',
        'submitted_at'
    ];

    protected $attributes = [
        'amount_requested'       => 0,
        'other_fundings'         => 0,
        'total_expected_income'  => 0,
        'total_expected_outcome' => 0,
    ];

    protected $casts = [
        'target_date' => 'array',
        'keywords' => 'array',
    ];

    protected $hidden = [
        'projectcall',
        'applicant',
        'offers',
        'evaluations'
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($application) {
            $result = DB::table('applications')->select('reference')
                ->where('projectcall_id', $application->projectcall->id)
                ->get();

            $last_reference = $result->pluck('reference')->map(function ($r) {
                list(,,, $ref) = explode('-', $r);
                return intval($ref);
            })->max();

            $application->reference = sprintf(
                "%s-%s",
                $application->projectcall->reference,
                str_pad(strval($last_reference + 1), 3, "0", STR_PAD_LEFT)
            );
        });
        static::deleting(function ($application) {
            foreach ($application->files as $file) {
                $file->delete();
            }
            $application->laboratories()->detach();
            $application->studyFields()->detach();
        });
    }

    public function projectcall()
    {
        return $this->belongsTo('App\ProjectCall', 'projectcall_id')->withTrashed();
    }

    public function applicant()
    {
        return $this->belongsTo('App\User', 'applicant_id');
    }

    public function carrier()
    {
        return $this->belongsTo('App\Person', 'carrier_id')->withDefault();
    }

    public function laboratories()
    {
        return $this->belongsToMany('App\Laboratory', 'application_laboratory', 'application_id', 'laboratory_id')->withPivot('order', 'contact_name');
    }

    public function carrierLaboratory()
    {
        return $this->laboratories()->wherePivot('order', 1);
    }

    public function studyFields()
    {
        return $this->belongsToMany('App\StudyField', 'application_study_field', 'application_id', 'study_field_id');
    }

    public function files()
    {
        return $this->hasMany('App\ApplicationFile')->orderBy('order', 'ASC');
    }

    public function offers()
    {
        return $this->hasMany('App\EvaluationOffer');
    }

    public function evaluations()
    {
        return $this->hasManyThrough('App\Evaluation', 'App\EvaluationOffer', 'application_id', 'offer_id', 'id', 'id');
    }
}
