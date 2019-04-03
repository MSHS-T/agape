<?php

namespace App\Exports;

use App\User;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class GlobalUsersSheet implements FromCollection, ShouldAutoSize, WithColumnFormatting, WithHeadings, WithMapping, WithStrictNullComparison, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::withTrashed()->get();
    }

    /**
     * @var User $user
     */
    public function map($user): array
    {
        return [
            $user->id,
            $user->last_name,
            $user->first_name,
            $user->email,
            $user->phone,
            \App\Enums\UserRole::getTranslatedLabel($user->role),
            $user->invited ? __('fields.yes') : __('fields.no'),
            !is_null($user->deleted_at) ? __('fields.yes') : __('fields.no'),
            Date::dateTimeToExcel($user->created_at),
            !is_null($user->updated_at) ? Date::dateTimeToExcel($user->updated_at) : __('fields.never'),
        ];
    }

    public function columnFormats(): array
    {
        return [
            'I' => __('locale.excel_datetime_format'),
            'J' => __('locale.excel_datetime_format'),
        ];
    }

    public function headings(): array
    {
        return __('exports.global.users.columns');
    }

    public function title(): string
    {
        return __('exports.global.users.name');
    }
}
