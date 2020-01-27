@extends('layouts.master')
@section('head_content')
    <style>
        @page {
            size: A4 portrait;
        }
        section {
            page-break-inside: avoid;
        }
        .page-break {
            page-break-after: always;
        }
        .text-center {
            text-align: center;
        }
        .evaluation_criteria, .row {
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
        p.lead, .col-9 > * {
            text-align: justify;
        }
    </style>
@endsection
@section('body')
    <h2 class="text-center">
        {{ config('app.name') }} - {!! __('actions.evaluation.export_name') !!} -
        {{ __('vocabulary.calltype_short.'.$projectcall->typeLabel) }} - {{ $projectcall->year }}
    </h2>
    @foreach($evaluations as $evaluation)
        <section>
            <h3 class="text-center">{{ __('fields.projectcall.applicant') }} : {{ $evaluation->offer->application->applicant->name }} ({{ $evaluation->offer->application->reference }})</h3>
            <h4 class="text-center">
                {{ __('fields.application.title.'.$projectcall->typeLabel)}} : {{ $evaluation->offer->application->title }}
                @if(!empty($evaluation->offer->application->acronym))
                    ({{ $evaluation->offer->application->acronym }})
                @endif
            </h4>
            <h5 class="text-center">{{ __('fields.application.laboratory_1')}} : {{ $evaluation->offer->application->laboratories->first()->name }}</h5>
            @if(!$anonymized)
            <h5 class="text-center">{{ __('fields.offer.expert')}} : {{ $evaluation->offer->expert->name }}</h5>
            @endif
            @include('partials.evaluation_display', ["evaluation" => $evaluation, "anonymized" => $anonymized])
        </section>
        @if(!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach
@endsection