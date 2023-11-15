<?php

namespace App\Models;

use App\Models\Contracts\WithCreator;
use App\Models\Traits\HasCreator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\StudyField
 *
 * @property int $id
 * @property array $name
 * @property int|null $creator_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @method static \Database\Factories\StudyFieldFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|StudyField mine()
 * @method static \Illuminate\Database\Eloquent\Builder|StudyField newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StudyField newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StudyField query()
 * @method static \Illuminate\Database\Eloquent\Builder|StudyField whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudyField whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudyField whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudyField whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|StudyField whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder|StudyField whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudyField whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class StudyField extends Model implements WithCreator
{
    use HasFactory;
    use HasCreator;
    use HasTranslations;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    public $translatable = ['name'];
}
