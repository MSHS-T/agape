<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ApplicationStudyField extends Pivot
{
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function studyField(): BelongsTo
    {
        return $this->belongsTo(StudyField::class);
    }
}
