<?php

namespace App\Exports;

use App\Application;
use App\ProjectCall;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ApplicationsExport implements FromArray, ShouldAutoSize, WithHeadings
{
    protected $projectcall;

    public function __construct(ProjectCall $projectcall)
    {
        $this->projectcall = $projectcall;
    }

    public function array(): array
    {
        $pc = $this->projectcall;
        return $pc->submittedApplications->map(function($application) use ($pc) {
            return [
                $application->id,
                $pc->toString(),
                $application->acronym,
                $application->applicant->name,
                $application->applicant->email,
                $application->applicant->phone,
            ];
        })->all();
    }

    public function headings(): array
    {
        return __('exports.applications.columns');
    }
}
