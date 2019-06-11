@extends('layouts.app')
@section('content')
<h2 class="mb-3 text-center">{{ __('actions.evaluation.show') }}</h2>

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
                @include('partials.projectcall_display', ["projectcall" => $evaluation->offer->application->projectcall])
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
                @include('partials.application_display', ["application" => $evaluation->offer->application])
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
                @include('partials.evaluation_display', ["evaluation" => $evaluation])
            </div>
        </div>
    </div>
</div>
<hr/>
@include('partials.back_button', ['url' => route('home')])


@endsection