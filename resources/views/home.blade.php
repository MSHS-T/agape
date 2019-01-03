@extends('layouts.app')
@section('content')
@switch(Auth::user()->role)
@case(\App\Enums\UserRole::Admin)
@include('home.admin')
@break
@case(\App\Enums\UserRole::Candidate)
@include('home.candidate')
@break
@case(\App\Enums\UserRole::Expert)
@include('home.expert')
@default
<script type="text/javascript">
    window.location = "/error";

</script>
@endswitch
<div class="jumbotron mt-4">
    {{ dump($projectcalls) }}
</div>
@endsection
