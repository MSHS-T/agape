<?php

namespace App\Exports;

use App\Models\Application;
use App\Models\ProjectCall;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ApplicationsExport implements FromQuery, WithMapping, ShouldAutoSize, WithHeadings, WithColumnFormatting, Responsable
{
    use Exportable;

    private $fileName;
    private $writerType = Excel::XLSX;

    public function __construct(protected ProjectCall $projectCall)
    {
        $this->fileName = config('app.name') . '-' . __('exports.applications.name') . '-' . $projectCall->reference . '-' . date('Y-m-d') . '.xlsx';
    }

    public function query()
    {
        return $this->projectCall
            ->applications()
            ->whereNotNull('submitted_at');
    }

    public function map($application): array
    {
        /**
         * @var Application $application
         */
        ray($application);
        return [
            $application->id,
            $this->projectCall->toString(),
            $application->reference,
            $application->acronym,
            $application->title,
            $application->creator->name,
            $application->creator->email,
            $application->creator->phone,
            Date::dateTimeToExcel($application->submitted_at),
        ];
    }

    public function columnFormats(): array
    {
        return [
            'I' => __('misc.excel_datetime_format'),
        ];
    }


    public function headings(): array
    {
        return __('exports.applications.columns');
    }
}
