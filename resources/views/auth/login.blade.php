@extends('layouts.app')
@section('head')
    {!! htmlScriptTagJsApi() !!}
@endsection
@section('content')
<div class="container">
    <div class="row align-items-center justify-content-center">
        <div class="col-md-8">

            <div class="text-center">
                <img class="mb-4" src="{{ URL::asset('/bandeau.jpg') }}" alt="" height="302">

                <h1 class="h3 mb-3 font-weight-normal">{{ __('auth.welcome1', ['appname' => config('app.name')]) }}</h1>
                <h1 class="h3 mb-3 font-weight-normal">{{ __('auth.welcome2') }}</h1>
            </div>
            <form method="POST" action="{{ route('login') }}" id="login_form">
                @csrf

                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('fields.email') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}"
                            required autofocus> @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span> @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('fields.password') }}</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                            required> @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span> @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6 offset-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old( 'remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                        {{ __('fields.remember_me') }}
                                    </label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6 offset-md-4">
                        {!! htmlFormSnippet() !!}
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{__("actions.login")}}
                        </button>
                        @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('passwords.forgot') }}
                            </a>
                        @endif
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-8 offset-2">
                    <h4 class="text-through-line mb-4">
                        <span class="text-uppercase">
                            {{ __('auth.or_register') }}
                        </span>
                    </h4>
                </div>
            </div>
            <div class="row">
                <div class="col-4 offset-4 text-center">

                    <a href="{{ route('register') }}" class="btn btn-success d-inline-block">
                        {{ __('actions.register') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection