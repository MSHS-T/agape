<?php

namespace App\Models;

use App\Models\Contracts\WithSubmission;
use App\Models\Traits\HasSubmission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

/**
 * App\Models\Evaluation
 *
 * @property int $id
 * @property int $grade1
 * @property int $grade2
 * @property int $grade3
 * @property int $global_grade
 * @property string $comment1
 * @property string $comment2
 * @property string $comment3
 * @property string $global_comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\EvaluationOffer|null $evaluationOffer
 * @method static \Database\Factories\EvaluationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Evaluation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Evaluation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Evaluation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Evaluation whereComment1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Evaluation whereComment2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Evaluation whereComment3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Evaluation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Evaluation whereGlobalComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Evaluation whereGlobalGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Evaluation whereGrade1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Evaluation whereGrade2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Evaluation whereGrade3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Evaluation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Evaluation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Evaluation extends Model implements WithSubmission
{
    use HasFactory;
    use HasSubmission;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'grade1',
        'grade2',
        'grade3',
        'global_grade',
        'comment1',
        'comment2',
        'comment3',
        'global_comment',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'           => 'integer',
    ];

    public function evaluationOffer(): BelongsTo
    {
        return $this->belongsTo(EvaluationOffer::class);
    }


    public function getSubmissionNotification(string $name): ?string
    {
        return [
            // TODO : fix notifications
            // 'submittedUser'   => ApplicationSubmittedApplicant::class,
            // 'submittedAdmins' => ApplicationSubmittedAdmins::class,
            // 'unsubmitted'     => ApplicationUnsubmitted::class,
            // 'forceSubmitted'  => ApplicationForceSubmitted::class,
        ][$name] ?? null;
    }

    public function resolveAdmins(): Collection|array
    {
        return $this->evaluationOffer->application->projectCall->projectCallType->managers
            ->concat(User::role('administrator')->get());
    }
}
