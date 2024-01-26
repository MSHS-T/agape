<?php

namespace App\Models;

use App\Models\Contracts\WithCreator;
use App\Models\Traits\HasCreator;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Laboratory
 *
 * @property int $id
 * @property string $name
 * @property string $unit_code
 * @property string $director_email
 * @property string $regency
 * @property int|null $creator_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @method static \Database\Factories\LaboratoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Laboratory mine()
 * @method static \Illuminate\Database\Eloquent\Builder|Laboratory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Laboratory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Laboratory query()
 * @method static \Illuminate\Database\Eloquent\Builder|Laboratory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Laboratory whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Laboratory whereDirectorEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Laboratory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Laboratory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Laboratory whereRegency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Laboratory whereUnitCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Laboratory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Laboratory extends Model implements WithCreator
{
    use HasFactory;
    use HasCreator;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'unit_code',
        'director_email',
        'regency',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    /**
     * CUSTOM ATTRIBUTES
     */
    public function displayName(): Attribute
    {
        return Attribute::make(
            get: fn () => sprintf("%s (%s ; %s)", $this->name, $this->unit_code, $this->regency)
        );
    }
}
