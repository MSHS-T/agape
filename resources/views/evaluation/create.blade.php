@extends('layouts.app')
@php($notation_grid = json_decode(\App\Setting::get('notation_grid'), true))
@section('content')
<h2 class="mb-3 text-center">{{ __('actions.evaluation.create') }}</h2>

<div id="accordion">
    <div class="card">
        <div class="card-header" id="evaluationCallTitle">
            <h4 class="mb-0">
                <button class="btn btn-link" data-toggle="collapse" data-target="#evaluationCall" aria-expanded="false" aria-controls="evaluationCall">
                    {{ __('actions.evaluation.call_data') }}
                </button>
            </h4>
        </div>

        <div id="evaluationCall" class="collapse" aria-labelledby="evaluationCallTitle" data-parent="#accordion">
            <div class="card-body">
                @include('partials.projectcall_display', ["projectcall" => $offer->application->projectcall])
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header" id="evaluationApplicationTitle">
            <h4 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#evaluationApplication" aria-expanded="false" aria-controls="evaluationApplication">
                    {{ __('actions.evaluation.application_data') }}
                </button>
            </h4>
        </div>
        <div id="evaluationApplication" class="collapse" aria-labelledby="evaluationApplicationTitle" data-parent="#accordion">
            <div class="card-body">
                @include('partials.application_display', ["application" => $offer->application])
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header" id="evaluationFormTitle">
            <h4 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#evaluationForm" aria-expanded="true" aria-controls="evaluationForm">
                    {{ __('actions.evaluation.evaluation_form') }}
                </button>
            </h4>
        </div>
        <div id="evaluationForm" class="collapse show" aria-labelledby="evaluationFormTitle" data-parent="#accordion">
            <div class="card-body">
                <form method="POST" action="{{ route('evaluation.store', $offer->id) }}" id="evaluation_form">
                    @csrf @method("POST")
                    @foreach(range(1,3) as $iteration)
                        <div class="jumbotron jumbotron-fluid px-1 py-2 mb-1">
                            <div class="container">
                                <h5>{{ \App\Setting::get("notation_{$iteration}_title") }}</h5>
                                <p class="lead">
                                    {!! \App\Setting::get("notation_{$iteration}_description") !!}
                                </p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3 col-form-label">{{ __('fields.evaluation.grade') }}</label>
                            <div class="col-9">
                                @foreach(range(0,3) as $grade)
                                    <div class="form-check">
                                        <input
                                            class="form-check-input" type="radio"
                                            name="grade{{$iteration}}"
                                            id="grade{{$iteration}}_{{$grade}}"
                                            value="{{$grade}}"
                                            @if(old("grade".$iteration, null) === $grade) checked @endif
                                        >
                                        <label class="form-check-label" for="grade{{$iteration}}_{{$grade}}">
                                            <span class="font-weight-bold">
                                                {{ $notation_grid[$grade]['grade'] }}
                                            </span>
                                            &nbsp;:&nbsp;
                                            {{ $notation_grid[$grade]['details'] }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @include('forms.textarea', [
                            'name'  => 'comment'.$iteration,
                            'label' => __('fields.comments'),
                            'value' => old('comment'.$iteration, "")
                        ])
                        <hr/>
                    @endforeach

                    <div class="jumbotron jumbotron-fluid px-1 py-2 mb-1">
                        <div class="container">
                            <h5 class="mb-0">{{ __('fields.evaluation.global_grade') }}</h5>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 col-form-label">{{ __('fields.evaluation.grade') }}</label>
                        <div class="col-9">
                            @foreach(range(0,3) as $grade)
                                <div class="form-check">
                                    <input
                                        class="form-check-input" type="radio"
                                        name="global_grade"
                                        id="global_grade_{{$grade}}"
                                        value="{{$grade}}"
                                        @if(old("grade".$iteration, null) === $grade) checked @endif
                                    >
                                    <label class="form-check-label" for="global_grade_{{$grade}}">
                                        <span class="font-weight-bold">
                                            {{ $notation_grid[$grade]['grade'] }}
                                        </span>
                                        &nbsp;:&nbsp;
                                        {{ $notation_grid[$grade]['details'] }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @include('forms.textarea', [
                        'name'  => 'global_comment',
                        'label' => __('fields.comments'),
                        'value' => old('global_comment', "")
                    ])
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                            <a href="{{ route('home') }}" class="btn btn-secondary">{{ __('actions.cancel') }}</a>
                            <button type="submit" name="save" class="btn btn-primary">
                                @svg('solid/check')
                                {{ __('actions.evaluation.submit') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection