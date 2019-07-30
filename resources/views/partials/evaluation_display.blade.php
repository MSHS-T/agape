@php($notation_grid = json_decode(\App\Setting::get('notation_grid'), true))
<form id="evaluation_form">
    @foreach(range(1,3) as $iteration)
        @php($grade = $evaluation->{"grade".$iteration})
        <div class="evaluation_criteria">
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
                    <label class="form-check-label">
                        <span class="font-weight-bold">
                            {{ $notation_grid[$grade]['grade'] }}
                        </span>
                        &nbsp;:&nbsp;
                        {{ $notation_grid[$grade]['details'] }}
                    </label>
                </div>
            </div>
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
    <div class="form-group row">
        <label class="col-3 col-form-label">{{ __('fields.evaluation.grade') }}</label>
        <div class="col-9">
            <label class="form-check-label">
                <span class="font-weight-bold">
                    {{ $notation_grid[$evaluation->global_grade]['grade'] }}
                </span>
                &nbsp;:&nbsp;
                {{ $notation_grid[$evaluation->global_grade]['details'] }}
            </label>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-3 col-form-label">{{ __('fields.comments') }}</label>
        <div class="col-9">
            {!! $evaluation->global_comment !!}
        </div>
    </div>
</form>