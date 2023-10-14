<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Evaluation extends Model
{
    use HasFactory;

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
        'id' => 'integer',
    ];

    public function evaluationOffer(): BelongsTo
    {
        return $this->belongsTo(EvaluationOffer::class);
    }
}
