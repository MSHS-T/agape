@php($notation_grid = json_decode(\App\Setting::get('notation_grid'), true))
@php($anonymized = $anonymized ?? false)
@php($noId = $noId ?? false)
@php($criteriaDetails = $criteriaDetails ?? true)

<form @if(!$noId)
    id="evaluation_form"
@endif >
    @foreach(range(1,3) as $iteration)
        @php($grade = $evaluation->{"grade".$iteration})
        <div class="evaluation_criteria">
            <div class="jumbotron jumbotron-fluid px-1 py-2 mb-1">
                <div class="container">
                    <h5>{{ \App\Setting::get("notation_{$iteration}_title") }}</h5>
                    @if($criteriaDetails)
                        <p class="lead">
                            {!! \App\Setting::get("notation_{$iteration}_description") !!}
                        </p>
                    @endif
                </div>
            </div>
            @if(!$anonymized)
                <div class="form-group row">
                    <label class="col-3 col-form-label">{{ __('fields.evaluation.grade') }}</label>
                    <div class="col-9">
                        <label class="form-check-label">
                            <span class="font-weight-bold">
                                {{ $grade !== null ? $notation_grid[$grade]['grade'] : '?' }}
                            </span>
                            &nbsp;:&nbsp;
                            {{ $grade !== null ? $notation_grid[$grade]['details'] : '?' }}
                        </label>
                    </div>
                </div>
            @endif
            <div class="form-group row">
                <label class="col-3 col-form-label">{{ __('fields.comments') }}</label>
                <div class="col-9">
                    {!! $evaluation->{"comment".$iteration} !!}
                </div>
            </div>
        </div>
        <hr/>
    @endforeach

    <div class="jumbotron jumbotron-fluid px-1 py-2 mb-1">
        <div class="container">
            <h5 class="mb-0">{{ __('fields.evaluation.global_grade') }}</h5>
        </div>
    </div>
    @if(!$anonymized)
        <div class="form-group row">
            <label class="col-3 col-form-label">{{ __('fields.evaluation.grade') }}</label>
            <div class="col-9">
                <label class="form-check-label">
                    <span class="font-weight-bold">
                        {{ $evaluation->global_grade !== null ? $notation_grid[$evaluation->global_grade]['grade'] : '?' }}
                    </span>
                    &nbsp;:&nbsp;
                    {{ $evaluation->global_grade !== null ? $notation_grid[$evaluation->global_grade]['details'] : '?' }}
                </label>
            </div>
        </div>
    @endif
    <div class="form-group row">
        <label class="col-3 col-form-label">{{ __('fields.comments') }}</label>
        <div class="col-9">
            {!! $evaluation->global_comment !!}
        </div>
    </div>
</form>