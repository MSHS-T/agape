<?php

namespace App\Exports;

use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\Exportable;

class ProjectCallsExport implements WithMultipleSheets, Responsable
{
    use Exportable;

    private $fileName;

    public function __construct()
    {
        $this->fileName = config('app.name') . '-' . __('actions.projectcall.list') . '-' . date('Y-m-d') . '.xlsx';
    }

    public function sheets(): array
    {
        return [
            new GlobalProjectCallsSheet
        ];
    }
}
