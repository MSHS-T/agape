<?php

namespace App\Http\Controllers;

use App\Exports\ApplicationsExport;
use App\Models\Application;
use App\Models\Evaluation;
use App\Models\ProjectCall;
use App\Utils\ApplicationExport;
use App\Utils\EvaluationExport;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use ZipStream\ZipStream;

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

    public function zipApplicationExport(Application $application, Request $request)
    {
        $zipName = Str::replace(" ", "_", implode('_', [
            config('app.name'),
            __('resources.application'),
            $application->reference,
        ]));

        list($pdfName, $pdf) = ApplicationExport::export($application);
        $pdfPath = tempnam(sys_get_temp_dir(), Str::slug(env('APP_NAME')) . '_');
        $pdf->save($pdfPath);

        $files = $application->media->map(fn (Media $media) => [
            'folder' => $media->collection_name,
            'name'   => $media->file_name,
            'path'   => $media->getPath(),
        ]);
        $files->prepend([
            'folder' => null,
            'name' => $pdfName . '.pdf',
            'path' => $pdfPath
        ]);

        // Evaluations
        list($evaluationPdfName, $evaluationPdf) = EvaluationExport::exportForApplication($application);
        $evaluationPdfPath = tempnam(sys_get_temp_dir(), Str::slug(env('APP_NAME')) . '_');
        $evaluationPdf->save($evaluationPdfPath);
        unset($evaluationPdf);

        $files->push([
            'folder' => null,
            'name'   => $evaluationPdfName . '.pdf',
            'path'   => $evaluationPdfPath
        ]);

        if ($request->has('debug')) {
            dump([
                'file_name' => $zipName . '.zip',
                'files'     => $files->all()
            ]);
            return;
        }

        return $this->zipResponse($zipName, $files);
    }

    public function zipProjectCallExport(ProjectCall $projectCall, Request $request)
    {
        $zipName = Str::replace(" ", "_", implode('_', [
            config('app.name'),
            __('resources.project_call'),
            $projectCall->reference,
        ]));

        $files = collect();
        foreach ($projectCall->applications as $application) {
            if (blank($application->submitted_at)) {
                continue;
            }
            list($applicationPdfName, $applicationPdf) = ApplicationExport::export($application);
            $applicationPdfPath = tempnam(sys_get_temp_dir(), Str::slug(env('APP_NAME')) . '_');
            $applicationPdf->save($applicationPdfPath);
            unset($applicationPdf);


            $applicationFiles = $application->media->map(fn (Media $media) => [
                'folder' => $application->reference . '/' . $media->collection_name,
                'name'   => $media->file_name,
                'path'   => $media->getPath(),
            ]);
            $applicationFiles->prepend([
                'folder' => $application->reference,
                'name' => $applicationPdfName . '.pdf',
                'path' => $applicationPdfPath
            ]);

            // Evaluations
            list($evaluationPdfName, $evaluationPdf) = EvaluationExport::exportForApplication($application);
            $evaluationPdfPath = tempnam(sys_get_temp_dir(), Str::slug(env('APP_NAME')) . '_');
            $evaluationPdf->save($evaluationPdfPath);
            unset($evaluationPdf);

            $applicationFiles->push([
                'folder' => $application->reference,
                'name' => $evaluationPdfName . '.pdf',
                'path' => $evaluationPdfPath
            ]);

            $files = $files->concat($applicationFiles);
        }

        if ($request->has('debug')) {
            dump([
                'file_name' => $zipName . '.zip',
                'files'     => $files->all()
            ]);
            return;
        }

        return $this->zipResponse($zipName, $files);
    }

    protected function zipResponse(string $zipName, iterable $files)
    {
        return response()->streamDownload(function () use ($zipName, $files) {
            $zip = new ZipStream(
                outputName: $zipName . '.zip',
                defaultEnableZeroHeader: true,
                contentType: 'application/octet-stream',
            );
            foreach ($files as $file) {
                $fileName = collect([$zipName, $file['folder'], $file['name']])->filter(fn ($v) => filled($v))->join('/');
                $zip->addFileFromPath(
                    fileName: $fileName,
                    path: $file['path'],
                );
            }
            $zip->finish();
        }, $zipName . '.zip');
    }
}
