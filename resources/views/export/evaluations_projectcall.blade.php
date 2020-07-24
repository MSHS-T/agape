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

    @foreach($application->evaluations as $evaluation)

    <h4 class="text-center title-bordered">
        <a name="evaluation-{{$evaluation->id}}">
            {{ __('fields.projectcall.evaluation')}} #{{$loop->iteration}}
        </a>
        @if(!$anonymized)
        : {{ $evaluation->offer->expert->name }}
        @endif
    </h4>

    <div class="evaluation">
        @include('partials.evaluation_display', ["evaluation" => $evaluation, "anonymized" => $anonymized])
    </div>

    @endforeach

    @if($application->selection_comity_opinion !== null)
    <h4 class="text-center title-bordered">
        <a name="application-{{$application->reference}}-comity">
            {{ __('fields.application.selection_comity_opinion') }}
        </a>
    </h4>
    <p class="evaluation">
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