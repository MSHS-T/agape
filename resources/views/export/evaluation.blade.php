@extends('layouts.master')
@section('head_content')
@include('export._style')
@endsection
@section('body')
<div id="agape-logo-wrapper">
    <img src="{{ base_path() }}/public/logo_ligne.png" alt="{{ config('app.name') }}" id="agape-logo">
</div>
<h3 class="text-center">
    {!! __('actions.evaluation.export_name') !!}
</h3>
<h3 class="text-center">
    {{ __('vocabulary.calltype_short.'.$projectcall->typeLabel) }} - {{ $projectcall->year }}
</h3>

@php ($application = $evaluation->offer->application)

<section>
    {{-- Display application data in a table --}}
    <table class="reference-table">
        <tr>
            <th>{{ __('fields.reference') }}</th>
            <td>
                <a name="application-{{$application->reference}}">
                    {{ $application->reference }}
                </a>
            </td>
        </tr>
        <tr>
            <th>{{ __('fields.projectcall.applicant') }}</th>
            <td>{{ $application->applicant->name }}</td>
        </tr>
        <tr>
            <th>{{ __('fields.application.title.'.$projectcall->typeLabel)}}</th>
            <td>
                {{ $application->title }}
                @if(!empty($application->acronym))
                ({{ $application->acronym }})
                @endif
            </td>
        </tr>
        <tr>
            <th>{{ __('fields.application.laboratory_1')}}</th>
            <td>{{ $application->laboratories->first()->name }}</td>
        </tr>
    </table>

    <h4 class="text-center title-bordered">
        <a name="evaluation-{{$evaluation->id}}">
            {{ __('fields.projectcall.evaluation')}} : {{ $evaluation->offer->expert->name }}
        </a>

    </h4>

    <div class="evaluation">
        @include('partials.evaluation_display', ["evaluation" => $evaluation, "anonymized" => $anonymized])
    </div>

</section>

<script type="text/php">
    if (isset($pdf)) {
        $text = "{PAGE_NUM} / {PAGE_COUNT}";
        $size = 10;
        $font = $fontMetrics->getFont("Arial");
        $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
        $x = ($pdf->get_width() - $width);
        $y = $pdf->get_height() - 35;
        $pdf->page_text($x, $y, $text, $font, $size);
    }
</script>

@endsection