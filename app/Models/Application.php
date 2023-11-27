<?php

namespace App\Models;

use App\Models\Contracts\WithSubmission;
use App\Models\Traits\HasCreator;
use App\Models\Traits\HasSchemalessAttributes;
use App\Models\Traits\HasSubmission;
use App\Notifications\ApplicationForceSubmitted;
use App\Notifications\ApplicationSubmittedAdmins;
use App\Notifications\ApplicationSubmittedApplicant;
use App\Notifications\ApplicationUnsubmitted;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\Application
 *
 * @property int $id
 * @property int $project_call_id
 * @property string $reference
 * @property string $title
 * @property string $acronym
 * @property string $theme
 * @property string $short_description
 * @property array $summary
 * @property array $keywords
 * @property string $other_laboratories
 * @property float $amount_requested
 * @property float $other_fundings
 * @property float $total_expected_income
 * @property float $total_expected_outcome
 * @property string $selection_comity_opinion
 * @property string $devalidation_message
 * @property \Spatie\SchemalessAttributes\SchemalessAttributes|null $extra_attributes
 * @property int|null $applicant_id
 * @property \Illuminate\Support\Carbon $submitted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $applicant
 * @property-read \App\Models\Carrier|null $carrier
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EvaluationOffer> $evaluationOffers
 * @property-read int|null $evaluation_offers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Laboratory> $laboratories
 * @property-read int|null $laboratories_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\ProjectCall $projectCall
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StudyField> $studyFields
 * @property-read int|null $study_fields_count
 * @method static \Database\Factories\ApplicationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Application newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Application newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Application query()
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereAcronym($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereAmountRequested($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereApplicantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereDevalidationMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereExtraAttributes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereOtherFundings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereOtherLaboratories($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereProjectCallId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereSelectionComityOpinion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereSubmittedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereSummary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereTheme($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereTotalExpectedIncome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereTotalExpectedOutcome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application withExtraAttributes()
 * @mixin \Eloquent
 */
class Application extends Model implements HasMedia, WithSubmission
{
    use HasCreator;
    use HasFactory;
    use InteractsWithMedia;
    use HasSchemalessAttributes;
    use HasTranslations;
    use HasSubmission;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_call_id',
        'title',
        'acronym',
        'carrier',
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
        'extra_attributes',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'                     => 'integer',
        'carrier'                => 'array',
        'keywords'               => 'array',
        'amount_requested'       => 'float',
        'other_fundings'         => 'float',
        'total_expected_income'  => 'float',
        'total_expected_outcome' => 'float',
        'applicant_id'           => 'integer',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['studyFields', 'laboratories'];

    public $translatable = ['summary'];


    public static function booted()
    {
        static::saving(function ($application) {
            // Clean data before saving
            $application->keywords = collect($application->keywords)->filter()->flatten()->values()->all();
        });

        // When creating, generate reference
        static::creating(function ($application) {
            $result = DB::table('applications')->select('reference')
                ->where('project_call_id', $application->projectCall->id)
                ->get();

            $last_reference = $result->pluck('reference')->map(function ($r) {
                list(,,, $ref) = explode('-', $r);
                return intval($ref);
            })->max();

            $application->reference = sprintf(
                "%s-%s",
                $application->projectCall->reference,
                str_pad(strval($last_reference + 1), 3, "0", STR_PAD_LEFT)
            );
        });
    }

    /**
     * RELATIONSHIPS
     */
    public function projectCall(): BelongsTo
    {
        return $this->belongsTo(ProjectCall::class);
    }

    public function studyFields(): BelongsToMany
    {
        return $this->belongsToMany(StudyField::class);
    }

    public function applicationLaboratories(): HasMany
    {
        return $this->hasMany(ApplicationLaboratory::class);
    }

    public function laboratories(): BelongsToMany
    {
        return $this->belongsToMany(Laboratory::class)->withPivot(['order', 'contact_name']);
    }

    public function evaluationOffers(): HasMany
    {
        return $this->hasMany(EvaluationOffer::class);
    }

    public function evaluations(): HasManyThrough
    {
        return $this->hasManyThrough(Evaluation::class, EvaluationOffer::class);
    }

    public function getSubmissionNotification(string $name): ?string
    {
        return [
            'submittedUser'   => ApplicationSubmittedApplicant::class,
            'submittedAdmins' => ApplicationSubmittedAdmins::class,
            'unsubmitted'     => ApplicationUnsubmitted::class,
            'forceSubmitted'  => ApplicationForceSubmitted::class,
        ][$name] ?? null;
    }

    public function resolveAdmins(): Collection|array
    {
        return $this->projectCall->projectCallType->managers
            ->concat(User::role('administrator')->get());
    }

    public function canBeUnsubmitted(): bool
    {
        return filled($this->submitted_at) && $this->projectCall->evaluation_start_date->isFuture();
    }
}
