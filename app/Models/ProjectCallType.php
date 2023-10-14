<?php

namespace App\Models;

use App\Models\Traits\HasSchemalessAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

class ProjectCallType extends Model
{
    use HasFactory;
    use HasSchemalessAttributes;
    use HasTranslations;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reference',
        'label_long',
        'label_short',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    public $translatable = ['label_long', 'label_short'];

    public function media(): BelongsToMany
    {
        return $this->belongsToMany(Media::class);
    }
}
