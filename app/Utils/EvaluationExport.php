<?php

namespace App\Utils;

use App\Models\Application;
use App\Models\Evaluation;
use App\Models\ProjectCall;
use Barryvdh\DomPDF\Facade\Pdf;

class EvaluationExport
{
    /**
     * Export the evaluations for a specific projectcall.
     */
    public static function exportForProjectCall(ProjectCall $projectCall, bool $anonymized = false)
    {
        $projectCall->load([
            'applications' => function ($query) {
                $query->whereNotNull('submitted_at');
            },
            'applications.evaluations' => function ($query) {
                $query->whereNotNull('submitted_at');
            }
        ]);

        $title = implode(' - ', [
            config('app.name'),
            __('admin.evaluation.export_name'),
            $projectCall->reference
        ]);

        $pdf = Pdf::loadView('export.evaluations_projectcall', [
            'applications' => $projectCall->applications()->get(),
            'projectCall'  => $projectCall,
            'anonymized'   => $anonymized,
        ]);
        return [$title, $pdf];
    }

    /**
     * Export the evaluations for a specific application.
     */
    public static function exportForApplication(Application $application, bool $anonymized = false)
    {
        $application->load('projectCall')->load(['evaluations' => function ($query) {
            $query->whereNotNull('submitted_at');
        }]);

        $title = implode(' - ', [
            config('app.name'),
            __('admin.evaluation.export_name'),
            $application->reference
        ]);

        $pdf = PDF::loadView('export.evaluations_application', [
            'application' => $application,
            'projectCall' => $application->projectCall,
            'anonymized'  => $anonymized
        ]);
        return [$title, $pdf];
    }

    /**
     * Export a single evaluation
     */
    public static function export(Evaluation $evaluation, bool $anonymized = false)
    {
        $title = implode(' - ', [
            config('app.name'),
            __('admin.evaluation.export_name'),
            $evaluation->evaluationOffer->application->reference,
            $evaluation->evaluationOffer->creator->initials
        ]);

        $pdf = PDF::loadView('export.evaluation', [
            'evaluation'  => $evaluation,
            'projectCall' => $evaluation->evaluationOffer->application->projectCall,
            'anonymized'  => $anonymized
        ]);
        return [$title, $pdf];
    }
}
