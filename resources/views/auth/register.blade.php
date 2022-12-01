@extends('layouts.app')
@section('head')
    {!! htmlScriptTagJsApi() !!}
@endsection
@section('content')
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-8">

                <div class="text-center">
                    <img class="mb-4" src="{{ URL::asset('/bandeau.jpg') }}" alt="" width="600">

                    <h1 class="h3 mb-3 font-weight-normal">{{ __('auth.register1', ['appname' => config('app.name')]) }}</h1>
                    <h1 class="h3 mb-3 font-weight-normal">{{ __('auth.register2') }}</h1>
                </div>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    @if ($invitation !== false)
                        <input type="hidden" name="invitation" value="{{ $invitation }}">
                    @endif
                    <div class="form-group row">
                        <label for="first_name" class="col-md-4 col-form-label text-md-right">{{ __('fields.first_name') }}</label>

                        <div class="col-md-6">
                            <input id="first_name" type="first_name" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}"
                                name="first_name" value="{{ old('first_name') }}" required autofocus>
                            @if ($errors->has('first_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('fields.last_name') }}</label>

                        <div class="col-md-6">
                            <input id="last_name" type="last_name" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}"
                                name="last_name" value="{{ old('last_name') }}" required autofocus>
                            @if ($errors->has('last_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('fields.email') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                                value="{{ old('email') }}" required autofocus aria-describedby="emailHelpBlock">
                            <small id="emailHelpBlock" class="form-text text-muted">
                                {{ __('auth.email_requirements') }}
                            </small>
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('fields.password') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                                required aria-describedby="passwordHelpBlock">
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                {{ __('auth.password_requirements') }}
                            </small>
                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">
                            {{ __('fields.password_confirmation') }}
                        </label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6 offset-md-4">
                            {!! htmlFormSnippet() !!}
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-success">
                                {{ __('actions.register') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
