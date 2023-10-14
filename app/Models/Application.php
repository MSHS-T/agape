<?php

namespace App\Models;

use App\Models\Traits\HasSchemalessAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Application extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasSchemalessAttributes;
    use HasTranslations;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'acronym',
        'theme',
        'short_description',
        'summary',
        'keywords',
        'other_laboratories',
        'amount_requested',
        'other_fundings',
        'total_expected_income',
        'total_expected_outcome',
        'selection_comity_opinion',
        'devalidation_message',
        'applicant_id',
        'submitted_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'                     => 'integer',
        'keywords'               => 'array',
        'amount_requested'       => 'float',
        'other_fundings'         => 'float',
        'total_expected_income'  => 'float',
        'total_expected_outcome' => 'float',
        'applicant_id'           => 'integer',
        'submitted_at'           => 'datetime',
    ];

    public $translatable = ['summary'];

    // TODO : When creating, generate reference
    // TODO : When creating, add user as applicant


    public function projectCall(): BelongsTo
    {
        return $this->belongsTo(ProjectCall::class);
    }

    public function carrier(): BelongsTo
    {
        return $this->belongsTo(Carrier::class);
    }

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'applicant_id');
    }

    public function studyFields(): BelongsToMany
    {
        return $this->belongsToMany(StudyField::class);
    }

    public function laboratories(): BelongsToMany
    {
        return $this->belongsToMany(Laboratory::class)->withPivot(['order']);
    }

    public function evaluationOffers(): HasMany
    {
        return $this->hasMany(EvaluationOffer::class);
    }
}
