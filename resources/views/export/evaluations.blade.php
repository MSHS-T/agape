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
    <h2 class="text-center">
        {{ config('app.name') }} - {!! __('actions.evaluation.export_name') !!} -
        {{ __('vocabulary.calltype_short.'.$projectcall->typeLabel) }} - {{ $projectcall->year }}
    </h2>
    @foreach($evaluations as $evaluation)
        <section class="page-break">
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
            @include('partials.evaluation_display', ["evaluation" => $evaluation])
        </section>
    @endforeach
@endsection