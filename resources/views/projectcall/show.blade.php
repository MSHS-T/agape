@extends('layouts.app')
@section('content')
<h2 class="mb-3 text-center">
    {{ __('actions.projectcall.show') }}
</h2>
<h3 class="text-center">{{
    __('vocabulary.calltype_short.'.$projectcall->typeLabel) }} :
    {{$projectcall->year}}
</h3>
<div class="application-display">
    <div class="row mb-3">
        <div class="col-3 font-weight-bold">{{ __('fields.projectcall.type') }}</div>
        <div class="col-9">
            {{ __('vocabulary.calltype_short.'.$projectcall->typeLabel) }}
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-3 font-weight-bold">{{ __('fields.projectcall.year') }}</div>
        <div class="col-9">{{ $projectcall->year }}</div>
    </div>
    <div class="row mb-3">
        <div class="col-3 font-weight-bold">{{ __('fields.projectcall.title') }}</div>
        <div class="col-9">{{ $projectcall->title }}</div>
    </div>
    <div class="row mb-3">
        <div class="col-3 font-weight-bold">{{ __('fields.projectcall.description') }}</div>
        <div class="col-9">{!! $projectcall->description !!}</div>
    </div>
    <div class="row mb-3">
        <div class="col-3 font-weight-bold">
            {{ __('fields.projectcall.calendar') }}
        </div>
        <div class="col-9">
            <p><u>{{ str_plural(__('fields.projectcall.application_period')) }} :</u> {{
                \Carbon\Carbon::parse($projectcall->application_start_date)->format(__('locale.date_format'))
                }}&nbsp;-&nbsp;{{
                \Carbon\Carbon::parse($projectcall->application_end_date)->format(__('locale.date_format')) }}
                <br />
                <u>{{ str_plural(__('fields.projectcall.evaluation_period')) }} :</u> {{
                \Carbon\Carbon::parse($projectcall->evaluation_start_date)->format(__('locale.date_format'))
                }}&nbsp;-&nbsp;{{
                \Carbon\Carbon::parse($projectcall->evaluation_end_date)->format(__('locale.date_format')) }}
            </p>
        </div>
    </div>
    @if(Auth::user()->role == \App\Enums\UserRole::Admin)
    <div class="row mb-3">
        <div class="col-3 font-weight-bold">{{ __('fields.projectcall.number_of_experts') }}</div>
        <div class="col-9">{{ $projectcall->number_of_experts }}</div>
    </div>
    <div class="row mb-3">
        <div class="col-3 font-weight-bold">{{ __('fields.projectcall.number_of_documents') }}</div>
        <div class="col-9">{{ $projectcall->number_of_documents }}</div>
    </div>
    @endif
    <div class="row mb-3">
        <div class="col-3 font-weight-bold">{{ __('fields.projectcall.privacy_clause') }}</div>
        <div class="col-9">{!! $projectcall->privacy_clause !!}</div>
    </div>
    @if(Auth::user()->role == \App\Enums\UserRole::Admin)
    <div class="row mb-3">
        <div class="col-3 font-weight-bold">{{ __('fields.projectcall.invite_email_fr') }}</div>
        <div class="col-9">{!! $projectcall->invite_email_fr !!}</div>
    </div>
    <div class="row mb-3">
        <div class="col-3 font-weight-bold">{{ __('fields.projectcall.invite_email_en') }}</div>
        <div class="col-9">{!! $projectcall->invite_email_en !!}</div>
    </div>
    @endif
    @if(in_array(Auth::user()->role, [\App\Enums\UserRole::Admin, \App\Enums\UserRole::Expert]))
    <div class="row mb-3">
        <div class="col-3 font-weight-bold">{{ __('fields.projectcall.help_experts') }}</div>
        <div class="col-9">{!! $projectcall->help_experts !!}</div>
    </div>
    @endif
    @if(in_array(Auth::user()->role, [\App\Enums\UserRole::Admin, \App\Enums\UserRole::Candidate]))
    <div class="row mb-3">
        <div class="col-3 font-weight-bold">{{ __('fields.projectcall.help_candidates') }}</div>
        <div class="col-9">{!! $projectcall->help_candidates !!}</div>
    </div>
    @endif
    <div class="row">
        <div class="col-12 text-center">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">{{ __('actions.back') }}</a>
        </div>
    </div>
</div>
@endsection
