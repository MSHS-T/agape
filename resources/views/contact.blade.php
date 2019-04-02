@extends('layouts.app')
@section('head')
    {!! htmlScriptTagJsApi() !!}
@endsection
@section('content')
<h2 class="mb-3 text-center">{{ __('actions.contact') }}</h2>
<form method="POST" action="{{ $form_action }}">
    @csrf @method("POST")
    @php($tabindex=0)
    @if($user !== null)
        <input type="hidden" name="name" value="{{$user->name}}">
        <input type="hidden" name="email" value="{{$user->email}}">
    @else
        @include('forms.textinput', [
            'name'     => 'name',
            'label'    => __('fields.name'),
            'value'    => old('name', ''),
            'tabindex' => ++$tabindex
        ])
        @include('forms.textinput', [
            'name'     => 'email',
            'label'    => __('fields.email'),
            'value'    => old('email', ''),
            'tabindex' => ++$tabindex
        ])
    @endif
    @include('forms.textarea', [
        'name'  => 'message',
        'label' => __('fields.message'),
        'value' => old('message', '')
    ])
    <div class="form-group row">
        <div class="col-9 offset-3">
            {!! htmlFormSnippet() !!}
        </div>
    </div>
    <hr />
    <div class="form-group row">
        <div class="col-9 offset-3">
            <a href="{{ $cancelRoute ?? route('home') }}" class="btn btn-secondary">{{ __('actions.cancel') }}</a>
            <button type="submit" class="btn btn-primary">@svg('solid/share') {{ __('actions.send') }}</button>
        </div>
    </div>

</form>
@endsection
