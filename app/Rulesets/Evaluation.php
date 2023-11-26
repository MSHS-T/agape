<?php

namespace App\Rulesets;

use App\Models\ProjectCall;
use App\Settings\GeneralSettings;
use Illuminate\Validation\Rule;

class Evaluation
{
    public static function rules(ProjectCall $projectCall): array
    {
        $generalSettings = app(GeneralSettings::class);
        $notationGrid = $projectCall->notation;
        $grades = $generalSettings->grades;
        $rules = [
            'notation'       => 'required|array|size:' . count($notationGrid),
            'grades'         => 'required|array|size:' . count($notationGrid),
            'grades.*'       => ['required', 'string', Rule::in(collect($grades)->pluck('grade')->all())],
            'global_grade'   => ['required', 'string', Rule::in(collect($grades)->pluck('grade')->all())],
            'comments'       => 'required|array|size:' . count($notationGrid),
            'comments.*'     => 'required|string',
            'global_comment' => 'required|string',

        ];

        return $rules;
    }
    public static function messages(ProjectCall $projectCall): array
    {
        $messages = [];
        return $messages;
    }
    public static function attributes(ProjectCall $projectCall): array
    {
        $attributes = [
            'grades.*'        => __('pages.evaluate.grade'),
            'global_grade'    => __('pages.evaluate.global_grade'),
            'comments.*'      => __('pages.evaluate.comment'),
            'global_comments' => __('pages.evaluate.global_comment'),
        ];
        return $attributes;
    }
}
