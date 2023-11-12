<?php

namespace App\Models;

use App\Models\Contracts\WithCreator;
use App\Models\Traits\HasCreator;
use App\Models\Traits\HasSchemalessAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
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
        'devalidation_message',
        'notation_1_title',
        'notation_1_description',
        'notation_2_title',
        'notation_2_description',
        'notation_3_title',
        'notation_3_description',
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
        'notation_1_title',
        'notation_1_description',
        'notation_2_title',
        'notation_2_description',
        'notation_3_title',
        'notation_3_description',
    ];

    public function projectCallType(): BelongsTo
    {
        return $this->belongsTo(ProjectCallType::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }
}
