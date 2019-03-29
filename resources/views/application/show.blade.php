@extends('layouts.app')
@section('content')
<h2 class="mb-3 text-center">
    {{ __('actions.application.show' . ($application->applicant_id != Auth::id() ? "_a" : "")) }}
</h2>
<h3 class="text-center">
    {{ $application->projectcall->toString() }}
</h3>
<h4 class="text-center">{{$application->projectcall->title}}</h4>
<p><u>{{ str_plural(__('fields.projectcall.application_period')) }} :</u> {{
    \Carbon\Carbon::parse($application->projectcall->application_start_date)->format(__('locale.date_format'))
    }}&nbsp;-&nbsp;{{
    \Carbon\Carbon::parse($application->projectcall->application_end_date)->format(__('locale.date_format')) }}
    <br />
    <u>{{ str_plural(__('fields.projectcall.evaluation_period')) }} :</u> {{
    \Carbon\Carbon::parse($application->projectcall->evaluation_start_date)->format(__('locale.date_format'))
    }}&nbsp;-&nbsp;{{
    \Carbon\Carbon::parse($application->projectcall->evaluation_end_date)->format(__('locale.date_format')) }}
</p>
@include('partials.application_display', ["application" => $application])
@include('partials.back_button')
@endsection
