<?php

namespace App\Models;

use App\Models\Contracts\WithCreator;
use App\Models\Traits\HasCreator;
use App\Models\Traits\HasSchemalessAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class ProjectCall extends Model implements HasMedia, WithCreator
{
    use HasFactory, SoftDeletes;
    use HasCreator;
    use InteractsWithMedia;
    use HasSchemalessAttributes;
    use HasTranslations;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_call_type_id',
        'reference',
        'year',
        'title',
        'description',
        'application_start_date',
        'application_end_date',
        'evaluation_start_date',
        'evaluation_end_date',
        'privacy_clause',
        'invite_email',
        'help_experts',
        'help_candidates',
        'notation',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'                     => 'integer',
        'application_start_date' => 'date',
        'application_end_date'   => 'date',
        'evaluation_start_date'  => 'date',
        'evaluation_end_date'    => 'date',
    ];

    public $translatable = [
        'title',
        'description',
        'privacy_clause',
        'invite_email',
        'help_experts',
        'help_candidates',
        'notation',
    ];

    public static function booted()
    {
        static::creating(function ($projectCall) {
            $result = DB::table('project_calls')
                ->where('project_call_type_id', $projectCall->project_call_type_id)
                ->where('year', $projectCall->year)
                ->count();
            $projectCall->reference = sprintf(
                "%s-%s-%s",
                substr(strval($projectCall->year), -2),
                ProjectCallType::find($projectCall->project_call_type_id)->reference,
                str_pad(strval(++$result), 2, "0", STR_PAD_LEFT)
            );
        });
    }

    public function projectCallType(): BelongsTo
    {
        return $this->belongsTo(ProjectCallType::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function evaluationOffers(): HasManyThrough
    {
        return $this->hasManyThrough(EvaluationOffers::class, Application::class);
    }
}
