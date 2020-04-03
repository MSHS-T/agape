@extends('layouts.app')
@php($notation_grid = json_decode(\App\Setting::get('notation_grid'), true))
@section('content')
<h2 class="mb-3 text-center">{{ __('actions.evaluation.create') }}</h2>

<div id="accordion">
    <div class="card border-0">
        <div class="card-header border-bottom-0" id="evaluationCallTitle">
            <h4 class="mb-0">
                <button class="btn btn-info collapsed" data-toggle="collapse" data-target="#evaluationCall" aria-expanded="false" aria-controls="evaluationCall">
                    <span class="collapsible-icon text-muted mr-2">
                        <span class="d-inline">@svg('solid/plus')</span>
                        <span class="d-none">@svg('solid/minus')</span>
                    </span>
                    {{ __('actions.evaluation.call_data') }}
                </button>
            </h4>
        </div>

        <div id="evaluationCall" class="collapse" aria-labelledby="evaluationCallTitle" data-parent="#accordion">
            <div class="card-body">
                @include('partials.projectcall_display', ["projectcall" => $evaluation->offer->application->projectcall])
            </div>
        </div>
    </div>
    <div class="card border-0">
        <div class="card-header border-bottom-0" id="evaluationApplicationTitle">
            <h4 class="mb-0">
                <button class="btn btn-info collapsed" data-toggle="collapse" data-target="#evaluationApplication" aria-expanded="false" aria-controls="evaluationApplication">
                    <span class="collapsible-icon text-muted mr-2">
                        <span class="d-inline">@svg('solid/plus')</span>
                        <span class="d-none">@svg('solid/minus')</span>
                    </span>
                    {{ __('actions.evaluation.application_data') }}
                </button>
            </h4>
        </div>
        <div id="evaluationApplication" class="collapse" aria-labelledby="evaluationApplicationTitle" data-parent="#accordion">
            <div class="card-body">
                @include('partials.application_display', ["application" => $evaluation->offer->application])
            </div>
        </div>
    </div>
    <div class="card border-0">
        <div class="card-header border-bottom-0" id="evaluationFormTitle">
            <h4 class="mb-0">
                <button class="btn btn-info" data-toggle="collapse" data-target="#evaluationForm" aria-expanded="true" aria-controls="evaluationForm">
                    <span class="collapsible-icon text-muted mr-2">
                        <span class="d-none">@svg('solid/plus')</span>
                        <span class="d-inline">@svg('solid/minus')</span>
                    </span>
                    {{ __('actions.evaluation.evaluation_form') }}
                </button>
            </h4>
        </div>
        <div id="evaluationForm" class="collapse show" aria-labelledby="evaluationFormTitle" data-parent="#accordion">
            <div class="card-body">
                <form method="POST" action="{{ route('evaluation.update', ["evaluation" => $evaluation]) }}" id="evaluation_form">
                    @csrf @method("PUT")
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
                                            @if(old("grade".$iteration, $evaluation->{"grade".$iteration}) === $grade) checked @endif
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
                            'value' => old('comment'.$iteration, $evaluation->{"comment".$iteration})
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
                                        @if(old("global_grade", $evaluation->global_grade) === $grade) checked @endif
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
                        'value' => old('global_comment', $evaluation->global_comment)
                    ])
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                            <a href="{{ route('home') }}" class="btn btn-secondary">
                                {{ __('actions.cancel') }}
                            </a>
                            <button type="submit" name="save" class="btn btn-primary">
                                @svg('solid/save')
                                {{ __('actions.save') }}
                            </button>
                            <a href="{{ route('evaluation.submit', ['evaluation' => $evaluation]) }}" class="btn btn-success submission-link">
                                @svg('solid/check')
                                {{ __('actions.evaluation.submit') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="confirm-submission" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('actions.evaluation.confirm_submission.title') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="{{__('actions.close')}}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{ __('actions.evaluation.confirm_submission.body') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('actions.cancel') }}</button>
                <form id="confirmation-form" action="" method="post">
                    @csrf @method('PUT')
                    <button class="btn btn-danger" type="submit">{{ __('actions.submit') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="error-submission" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('fields.error') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="{{__('actions.close')}}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{ __('actions.evaluation.confirm_submission.error_unsaved') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('actions.close') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
    var form_old;
    $(document).ready(function () {
        form_old = $("form#evaluation_form").serialize();

        $('.submission-link').click(function (e) {
            e.preventDefault();
            var form_dirty = $("form#evaluation_form").serialize();
            if (form_old === form_dirty) {
                var targetUrl = jQuery(this).attr('href');
                $("form#confirmation-form").attr('action', targetUrl);
                $(".modal#confirm-submission").modal();
            } else {
                $('.modal#error-submission').modal();
            }
        });

        $('.collapse').on('show.bs.collapse', function () {
            var id = $(this).prop('id');
            var icons = $('button[data-target="#'+id+'"]').children('span.collapsible-icon').children('span');
            $(icons.get(0)).removeClass('d-inline').addClass('d-none');
            $(icons.get(1)).removeClass('d-none').addClass('d-inline');
        })
        $('.collapse').on('hide.bs.collapse', function () {
            var id = $(this).prop('id');
            var icons = $('button[data-target="#'+id+'"]').children('span.collapsible-icon').children('span');
            $(icons.get(0)).removeClass('d-none').addClass('d-inline');
            $(icons.get(1)).removeClass('d-inline').addClass('d-none');
        })
    });

</script>
@endpush
