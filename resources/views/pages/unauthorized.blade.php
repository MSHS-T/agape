@extends('layouts.app')
@section('content')
<h2 class="mb-3 text-center color-danger">{!! __('actions.error.unauthorized', ['roles' => implode(', ', $roles)]) !!}</h2>
@endsection