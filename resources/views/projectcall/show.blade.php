@extends('layouts.app')
@section('content')
<h2 class="mb-3 text-center">
    {{ __('actions.projectcall.show') }}
</h2>
<h3 class="text-center">{{
    __('vocabulary.calltype_short.'.$projectcall->typeLabel) }} :
    {{$projectcall->year}}
</h3>
@include('partials.projectcall_display', ["projectcall" => $projectcall])
@include('partials.back_button')
@endsection
