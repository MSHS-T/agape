<?php

namespace App\Models;

use App\Models\Contracts\WithCreator;
use App\Models\Traits\HasCreator;
use App\Models\Traits\HasSchemalessAttributes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\EvaluationOffer
 *
 * @property int $id
 * @property bool|null $accepted
 * @property string $justification
 * @property \Spatie\SchemalessAttributes\SchemalessAttributes|null $extra_attributes
 * @property int|null $creator_id
 * @property int|null $expert_id
 * @property int|null $invitation_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Application|null $application
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\Evaluation|null $evaluation
 * @property-read \App\Models\User|null $expert
 * @property-read \App\Models\Invitation|null $invitation
 * @method static \Database\Factories\EvaluationOfferFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|EvaluationOffer mine()
 * @method static \Illuminate\Database\Eloquent\Builder|EvaluationOffer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EvaluationOffer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EvaluationOffer query()
 * @method static \Illuminate\Database\Eloquent\Builder|EvaluationOffer whereAccepted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EvaluationOffer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EvaluationOffer whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EvaluationOffer whereExpertId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EvaluationOffer whereExtraAttributes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EvaluationOffer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EvaluationOffer whereInvitationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EvaluationOffer whereJustification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EvaluationOffer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EvaluationOffer withExtraAttributes()
 * @mixin \Eloquent
 */
class EvaluationOffer extends Model implements WithCreator
{
    use HasFactory;
    use HasCreator;
    use HasSchemalessAttributes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'accepted',
        'justification',
        'expert_id',
        'invitation_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'            => 'integer',
        'accepted'      => 'boolean',
        'expert_id'     => 'integer',
        'invitation_id' => 'integer',
    ];

    /**
     * RELATIONS
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function expert(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }

    public function evaluation(): HasOne
    {
        return $this->hasOne(Evaluation::class);
    }

    /**
     * SCOPES
     */
    public function scopeAffectedToMe(Builder $query)
    {
        return $query->where('expert_id', Auth::id());
    }

    public function scopePendingReply(Builder $query)
    {
        return $query->whereNull('accepted');
    }

    public function scopeAccepted(Builder $query)
    {
        return $query->where('accepted', true);
    }

    public function scopeEvaluationPending(Builder $query)
    {
        return $query->whereHas('evaluation', fn (Builder $query) => $query->whereNull('submitted_at'));
    }

    public function scopeEvaluationDone(Builder $query)
    {
        return $query->whereHas('evaluation', fn (Builder $query) => $query->whereNotNull('submitted_at'));
    }

    /**
     * HELPER METHODS
     */
    public function retry()
    {
        $this->extra_attributes->retry_count = ($this->extra_attributes->retry_count ?? 0) + 1;
        $this->extra_attributes->retries = array_merge(
            $this->extra_attributes->retries ?? [],
            [['at' => now()->toDateTimeString(), 'by' => Auth::id()]]
        );
        $this->save();
        // Send EvaluationOfferRetry notification
        // $invitation->notify((new UserInvitationRetry($invitation))->locale($invitation->extra_attributes->lang));
    }
}
