@extends('layouts.master')
@section('head_content')
<style>
    * {
        font-family: Arial, Helvetica, sans-serif;
    }

    @page {
        size: A4 portrait;
        margin: 5mm;
    }

    img {
        width: 100%;
    }

    section {
        page-break-inside: avoid;
    }

    table,
    table tr,
    table td,
    table th {
        border: 1px solid black;
        border-collapse: collapse;
    }

    .page-break {
        page-break-after: always;
    }

    .text-center {
        text-align: center;
    }

    .title-bordered {
        border: 2px solid black;
    }

    .evaluation_criteria,
    .row {
        page-break-inside: avoid;
        display: block;
    }

    .col-3 {
        width: 20%;
        display: inline;
        font-weight: bold;
        text-decoration: underline;
    }

    .col-9 {
        width: 80%;
        display: inline;
        text-align: justify;
    }

    p.lead,
    .col-9>* {
        text-align: justify;
    }
</style>
@endsection
@section('body')
<img src="{{ base_path() }}/public/logo_ligne.png" alt="{{ config('app.name') }}">
<h1 class="text-center">
    {!! __('actions.evaluation.export_name') !!}
</h1>
<h1 class="text-center">
    {{ __('vocabulary.calltype_short.'.$projectcall->typeLabel) }} - {{ $projectcall->year }}
</h1>
{{-- Table of contents --}}
<ol>
    @foreach ($applications as $application)
    <li>
        <a href="#application-{{$application->reference}}">
            {{ $application->applicant->name }} - {{ $application->title }}
            @if(!empty($application->acronym))
            ({{ $application->acronym }})
            @endif</a>

        <ul>
            @foreach($application->evaluations as $evaluation)
            <li>
                <a href="#evaluation-{{$evaluation->id}}">
                    {{ __('fields.projectcall.evaluation')}} #{{$loop->iteration}}
                    @if(!$anonymized)
                    : {{ $evaluation->offer->expert->name }}
                    @endif
                </a>
            </li>
            @endforeach
            @if($application->selection_comity_opinion !== null)
            <li>
                <a href="#application-{{$application->reference}}-comity">
                    {{ __('fields.application.selection_comity_opinion') }}
                </a>
            </li>
            @endif
        </ul>
    </li>
    @endforeach
</ol>

@foreach($applications as $application)
{{-- Start a new page for each application --}}
<div class="page-break"></div>
<section>
    {{-- Display application data in a table --}}
    <table>
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

    @foreach($application->evaluations as $evaluation)

    <h2 class="text-center title-bordered">
        <a name="evaluation-{{$evaluation->id}}">
            {{ __('fields.projectcall.evaluation')}} #{{$loop->iteration}}
        </a>
        @if(!$anonymized)
        : {{ $evaluation->offer->expert->name }}
        @endif
    </h2>

    @include('partials.evaluation_display', ["evaluation" => $evaluation, "anonymized" =>
    $anonymized])

    @endforeach

    @if($application->selection_comity_opinion !== null)
    <h2 class="text-center title-bordered">
        <a name="application-{{$application->reference}}-comity">
            {{ __('fields.application.selection_comity_opinion') }}
        </a>
    </h2>
    <p>
        {{ $application->selection_comity_opinion }}
    </p>
    @endif
</section>


@endforeach

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