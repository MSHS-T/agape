@extends('layouts.master')
@section('head_content')
    <style>
        .page-break {
            page-break-after: always;
            page-break-inside: avoid;
        }
        .page-break:last-child{
            page-break-after: avoid;
        }
        .text-center {
            text-align: center;
        }
        .row {
            clear: both;
        }
        .col-3 {
            width: 25%;
            float: left;
        }
        .col-9 {
            width: 75%;
        }
    </style>
@endsection
@section('body')
    <h1 class="text-center">
        {{ config('app.name') }} - {!! __('actions.evaluation.export_name') !!} -
        {{ __('vocabulary.calltype_short.'.$projectcall->typeLabel) }} - {{ $projectcall->year }}
    </h1>
    @foreach($evaluations as $evaluation)
        <section class="page-break">
            <h2 class="text-center">{{ __('fields.projectcall.applicant') }} : {{ $evaluation->offer->application->applicant->name }} ({{ $evaluation->offer->application->reference }})</h2>
            <h3 class="text-center">
                {{ __('fields.application.title.'.$projectcall->typeLabel)}} : {{ $evaluation->offer->application->title }}
                @if(!empty($evaluation->offer->application->acronym))
                    ({{ $evaluation->offer->application->acronym }})
                @endif
            </h3>
            <h3 class="text-center">{{ __('fields.application.laboratory_1')}} : {{ $evaluation->offer->application->laboratories->first()->name }}</h3>
            @if(!$anonymized)
            <h4 class="text-center">{{ __('fields.offer.expert')}} : {{ $evaluation->offer->expert->name }}</h4>
            @endif
            @include('partials.evaluation_display', ["evaluation" => $evaluation])
        </section>
    @endforeach
@endsection