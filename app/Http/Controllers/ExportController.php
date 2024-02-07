<?php

namespace App\Http\Controllers;

use App\Exports\ApplicationsExport;
use App\Models\Application;
use App\Models\Evaluation;
use App\Models\ProjectCall;
use App\Utils\ApplicationExport;
use App\Utils\EvaluationExport;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function applicationExportForProjectCall(ProjectCall $projectCall, Request $request)
    {
        return new ApplicationsExport($projectCall);
    }

    public function applicationExport(Application $application, Request $request)
    {
        list($title, $pdf) = ApplicationExport::export($application, $request->has('debug'));
        return $request->has('debug')
            ? $pdf
            : $pdf->stream($title . '.pdf');
    }

    public function evaluationExportForProjectCall(ProjectCall $projectCall, Request $request)
    {
        list($title, $pdf) = EvaluationExport::exportForProjectCall($projectCall, $request->has('anonymized'), $request->has('debug'));
        return $request->has('debug')
            ? $pdf
            : $pdf->stream($title . '.pdf');
    }
    public function evaluationExportForApplication(Application $application, Request $request)
    {
        list($title, $pdf) = EvaluationExport::exportForApplication($application, $request->has('anonymized'), $request->has('debug'));
        return $request->has('debug')
            ? $pdf
            : $pdf->stream($title . '.pdf');
    }
    public function evaluationExport(Evaluation $evaluation, Request $request)
    {
        list($title, $pdf) = EvaluationExport::export($evaluation, $request->has('anonymized'), $request->has('debug'));
        return $request->has('debug')
            ? $pdf
            : $pdf->stream($title . '.pdf');
    }
}
