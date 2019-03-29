@extends('layouts.app')
@section('content')
<h2 class="mb-3 text-center">
    {{ __('actions.application.show' . ($application->applicant_id != Auth::id() ? "_a" : "")) }}
</h2>
<h3 class="text-center">
    {{ $application->projectcall->toString() }}
</h3>
<p>
    @include('partials.projectcall_dates', ['projectcall' => $application->projectcall])
</p>
@include('partials.application_display', ["application" => $application])
@include('partials.back_button')
@endsection
