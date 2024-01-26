<?php

namespace App\Utils;

use App\Models\Application;
use App\Models\Evaluation;
use App\Models\ProjectCall;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as DomPDF;
use Illuminate\Contracts\View\View;

class EvaluationExport
{
    public static function getPdf(string $viewName, array $data, bool $debug = false): DomPDF|View
    {
        if ($debug) {
            return view($viewName, [...$data, 'debug' => $debug]);
        } else {
            return Pdf::loadView($viewName, [...$data, 'debug' => $debug]);
        }
    }
    /**
     * Export the evaluations for a specific projectcall.
     */
    public static function exportForProjectCall(ProjectCall $projectCall, bool $anonymized = false, bool $debug = false)
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

        $data = [
            'applications' => $projectCall->applications()->get(),
            'projectCall'  => $projectCall,
            'anonymized'   => $anonymized,
        ];

        return [$title, self::getPdf('export.evaluations_projectcall', $data, $debug)];
    }

    /**
     * Export the evaluations for a specific application.
     */
    public static function exportForApplication(Application $application, bool $anonymized = false, bool $debug = false)
    {
        $application->load('projectCall')->load(['evaluations' => function ($query) {
            $query->whereNotNull('submitted_at');
        }]);

        $title = implode(' - ', [
            config('app.name'),
            __('admin.evaluation.export_name'),
            $application->reference
        ]);

        $data = [
            'application' => $application,
            'projectCall' => $application->projectCall,
            'anonymized'  => $anonymized
        ];

        return [$title, self::getPdf('export.evaluations_application', $data, $debug)];
    }

    /**
     * Export a single evaluation
     */
    public static function export(Evaluation $evaluation, bool $anonymized = false, bool $debug = false)
    {
        $title = implode(' - ', [
            config('app.name'),
            __('admin.evaluation.export_name'),
            $evaluation->evaluationOffer->application->reference,
            $evaluation->evaluationOffer->creator->initials
        ]);

        $data = [
            'evaluation'  => $evaluation,
            'projectCall' => $evaluation->evaluationOffer->application->projectCall,
            'anonymized'  => $anonymized
        ];

        return [$title, self::getPdf('export.evaluation', $data, $debug)];
    }
}
