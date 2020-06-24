<?php

namespace App\Exports;

use App\EvaluationOffer;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class GlobalEvaluationsSheet implements FromCollection, ShouldAutoSize, WithColumnFormatting, WithHeadings, WithMapping, WithStrictNullComparison, WithTitle
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return EvaluationOffer::with('application', 'application.projectcall', 'expert', 'evaluation')->get();
    }

    /**
     * @var EvaluationOffer $offer
     */
    public function map($offer): array
    {
        $notation_grid = json_decode(\App\Setting::get('notation_grid'), true);
        if ($offer->accepted === false || $offer->accepted === 0)
            $status = __('fields.offer.declined');
        else if (is_null($offer->accepted) || is_null($offer->evaluation)) {
            $status          = __('fields.offer.pending');
            $offer->accepted = null;
        } else {
            if (is_null($offer->evaluation->submitted_at))
                $status = __('fields.offer.accepted');
            else
                $status = __('fields.offer.done');
        }
        return [
            $offer->id,
            $offer->application->projectcall->toString(),
            $offer->application->acronym,
            $offer->expert->name ?? '?',
            $status,
            $offer->justification ?? "",
            $offer->accepted ? (!is_null($offer->evaluation->grade1)
                ? $notation_grid[$offer->evaluation->grade1]['grade']
                : "") : "",
            $offer->accepted ? ($offer->evaluation->comment1 ?? "") : "",
            $offer->accepted ? (!is_null($offer->evaluation->grade2)
                ? $notation_grid[$offer->evaluation->grade2]['grade']
                : "") : "",
            $offer->accepted ? ($offer->evaluation->comment2 ?? "") : "",
            $offer->accepted ? (!is_null($offer->evaluation->grade3)
                ? $notation_grid[$offer->evaluation->grade3]['grade']
                : "") : "",
            $offer->accepted ? ($offer->evaluation->comment3 ?? "") : "",
            $offer->accepted ? (!is_null($offer->evaluation->global_grade)
                ? $notation_grid[$offer->evaluation->global_grade]['grade']
                : "") : "",
            $offer->accepted ? ($offer->evaluation->global_comment ?? "") : "",
            $offer->accepted
                ? (Date::dateTimeToExcel(\Carbon\Carbon::parse($offer->evaluation->created_at)))
                : "",
            $offer->accepted ? (!is_null($offer->evaluation->submitted_at)
                ? Date::dateTimeToExcel(\Carbon\Carbon::parse($offer->evaluation->submitted_at))
                : "") : "",
        ];
    }

    public function columnFormats(): array
    {
        return [
            'O' => __('locale.excel_datetime_format'),
            'P' => __('locale.excel_datetime_format'),
        ];
    }

    public function headings(): array
    {
        return __('exports.global.evaluations.columns');
    }

    public function title(): string
    {
        return __('exports.global.evaluations.name');
    }
}
