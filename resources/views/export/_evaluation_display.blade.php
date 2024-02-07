@php
    $generalSettings = app(\App\Settings\GeneralSettings::class);
    $grades = $generalSettings->grades;
    $notationGrid = $evaluation->evaluationOffer->application->projectCall->notation;
    $anonymized = $anonymized ?? false;
    $noId = $noId ?? false;
    $criteriaDetails = $criteriaDetails ?? true;
@endphp

<form @if (!$noId) id="evaluation_form" @endif>
    @foreach ($notationGrid as $iteration => $criteria)
        @php
            $criteriaGrade = $evaluation->grades[$iteration];
            $grade = collect($grades)
                ->where('grade', $criteriaGrade)
                ->first();
        @endphp
        <div class="evaluation_criteria">
            <div class="jumbotron jumbotron-fluid px-1 py-2 mb-1">
                <div class="container">
                    <h5>{{ $criteria['title'][app()->getLocale()] }}</h5>
                    @if ($criteriaDetails)
                        <p class="lead">
                            {!! $criteria['description'][app()->getLocale()] !!}
                        </p>
                    @endif
                </div>
            </div>
            @if (!$anonymized)
                <div class="form-group row">
                    <label class="col-3 col-form-label">{{ __('pages.evaluate.grade') }}</label>
                    <div class="col-9">
                        <label class="form-check-label">
                            <span class="font-weight-bold">
                                {{ $grade !== null ? $grade['grade'] : '?' }}
                            </span>
                            &nbsp;:&nbsp;
                            {{ $grade !== null ? $grade['label'][app()->getLocale()] : '?' }}
                        </label>
                    </div>
                </div>
            @endif
            <div class="form-group row">
                <label class="col-3 col-form-label">{{ __('pages.evaluate.comment') }}</label>
                <div class="col-9">
                    {!! $evaluation->comments[$iteration] !!}
                </div>
            </div>
        </div>
        <hr />
    @endforeach

    <div class="jumbotron jumbotron-fluid px-1 py-2 mb-1">
        <div class="container">
            <h5 class="mb-0">{{ __('pages.evaluate.global_grade') }}</h5>
        </div>
    </div>
    @if (!$anonymized)
        @php
            $grade = collect($grades)
                ->where('grade', $evaluation->global_grade)
                ->first();
        @endphp
        <div class="form-group row">
            <label class="col-3 col-form-label">{{ __('pages.evaluate.grade') }}</label>
            <div class="col-9">
                <label class="form-check-label">
                    <span class="font-weight-bold">
                        {{ $grade !== null ? $grade['grade'] : '?' }}
                    </span>
                    &nbsp;:&nbsp;
                    {{ $grade !== null ? $grade['label'][app()->getLocale()] : '?' }}
                </label>
            </div>
        </div>
    @endif
    <div class="form-group row">
        <label class="col-3 col-form-label">{{ __('pages.evaluate.global_comment') }}</label>
        <div class="col-9">
            {!! $evaluation->global_comment !!}
        </div>
    </div>
</form>
