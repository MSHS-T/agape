<?php

namespace App\Exports;

use App\Application;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class GlobalApplicationsSheet implements FromCollection, ShouldAutoSize, WithColumnFormatting, WithHeadings, WithMapping, WithStrictNullComparison, WithTitle
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Application::with('projectcall', 'applicant', 'carrier', 'laboratories', 'studyFields')->get();
    }

    /**
     * @var Application $application
     */
    public function map($application): array
    {
        return [
            $application->id,
            $application->projectcall->toString(),
            $application->acronym,
            $application->title,
            $application->carrier->name,
            !empty($application->laboratories)
                ? implode(', ', $application->laboratories->pluck('name')->all())
                : "",
            !empty($application->keywords)
                ? implode(
                    ', ',
                    is_array($application->keywords)
                        ? $application->keywords
                        : json_decode($application->keywords, true)
                )
                : "",
            !empty($application->studyFields)
                ? implode(', ', $application->studyFields->pluck('name')->all())
                : "",
            count($application->evaluations->filter(function ($eval) {
                return !is_null($eval->submitted_at);
            })),
            $application->applicant->name,
            Date::dateTimeToExcel($application->created_at),
            !is_null($application->submitted_at)
                ? Date::dateTimeToExcel(\Carbon\Carbon::parse($application->submitted_at))
                : ""
        ];
    }

    public function columnFormats(): array
    {
        return [
            'K' => __('locale.excel_datetime_format'),
            'L' => __('locale.excel_datetime_format'),
        ];
    }

    public function headings(): array
    {
        return __('exports.global.applications.columns');
    }

    public function title(): string
    {
        return __('exports.global.applications.name');
    }
}
