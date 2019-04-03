<?php

namespace App\Exports;

use App\Application;
use App\ProjectCall;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ApplicationsExport implements FromArray, ShouldAutoSize
{
    protected $projectcall;

    public function __construct(ProjectCall $projectcall)
    {
        $this->projectcall = $projectcall;
    }

    /**
     * @return array
     */
    public function array(): array
    {
        $pc = $this->projectcall;
        $data = $pc->submittedApplications->map(function($application) use ($pc) {
            return [
                $application->id,
                $pc->toString(),
                $application->acronym,
                $application->applicant->name,
                $application->applicant->email,
                $application->applicant->phone,
            ];
        })->all();
        array_unshift($data, __('exports.applications.columns'));
        return $data;
    }
}
