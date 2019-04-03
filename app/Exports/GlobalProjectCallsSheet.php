<?php

namespace App\Exports;

use App\ProjectCall;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class GlobalProjectCallsSheet implements FromCollection, ShouldAutoSize, WithColumnFormatting, WithHeadings, WithMapping, WithStrictNullComparison, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ProjectCall::withTrashed()->get();
    }

    /**
     * @var ProjectCall $projectcall
     */
    public function map($projectcall): array
    {
        return [
            $projectcall->id,
            $projectcall->typeLabel,
            $projectcall->year,
            $projectcall->title ?? "",
            Date::dateTimeToExcel(\Carbon\Carbon::parse($projectcall->application_start_date)),
            Date::dateTimeToExcel(\Carbon\Carbon::parse($projectcall->application_end_date)),
            Date::dateTimeToExcel(\Carbon\Carbon::parse($projectcall->evaluation_start_date)),
            Date::dateTimeToExcel(\Carbon\Carbon::parse($projectcall->evaluation_end_date)),
            count($projectcall->submittedApplications),
            $projectcall->evaluationCount,
            Date::dateTimeToExcel($projectcall->created_at),
            Date::dateTimeToExcel($projectcall->updated_at),
            !is_null($projectcall->deleted_at) ? Date::dateTimeToExcel($projectcall->deleted_at) : "",
        ];
    }

    public function columnFormats(): array
    {
        return [
            'E' => __('locale.excel_date_format'),
            'F' => __('locale.excel_date_format'),
            'G' => __('locale.excel_date_format'),
            'H' => __('locale.excel_date_format'),
            'K' => __('locale.excel_datetime_format'),
            'L' => __('locale.excel_datetime_format'),
            'M' => __('locale.excel_datetime_format'),
        ];
    }

    public function headings(): array
    {
        return __('exports.global.projectcalls.columns');
    }

    public function title(): string
    {
        return __('exports.global.projectcalls.name');
    }
}
