<?php

namespace App\Actions;

use App\Models\Invitation;
use App\Models\ProjectCall;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class DuplicateProjectCall
{
    public static function handle(ProjectCall $projectCall, array $data): void
    {
        $newProjectCall = new ProjectCall([
            'project_call_type_id'   => $projectCall->project_call_type_id,
            'year'                   => $data['year'],
            'title'                  => $projectCall->title,
            'description'            => $projectCall->description,
            'application_start_date' => $data['application_start_date'],
            'application_end_date'   => $data['application_end_date'],
            'evaluation_start_date'  => $data['evaluation_start_date'],
            'evaluation_end_date'    => $data['evaluation_end_date'],
            'privacy_clause'         => $projectCall->privacy_clause,
            'invite_email'           => $projectCall->invite_email,
            'help_experts'           => $projectCall->help_experts,
            'help_candidates'        => $projectCall->help_candidates,
            'notation'               => $projectCall->notation,
            'extra_attributes'       => $projectCall->extra_attributes,
        ]);

        $newProjectCall->save();
    }
}
