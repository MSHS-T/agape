@extends('layouts.app')
@section('content')
    @switch(Auth::user()->role)
        @case(\App\Enums\UserRole::Admin)
        @case(\App\Enums\UserRole::Manager)
            @include('home.admin')
        @break

        @case(\App\Enums\UserRole::Candidate)
            @include('home.candidate')
        @break

        @case(\App\Enums\UserRole::Expert)
            @include('home.expert')
        @break;

        @default
            <script type="text/javascript">
                window.location = "/error";
            </script>
    @endswitch
@endsection
