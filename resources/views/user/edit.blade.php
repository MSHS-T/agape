@extends('layouts.app')
@section('content')
<h2 class="mb-3 text-center">{{ __('actions.edit_profile') }}</h2>
<form method="POST" action="{{ $form_action }}">
    @csrf @method("POST")
    @if(Auth::user()->isAdmin())
        <div class="form-group row">
            <label for="inputId" class="col-sm-3 col-form-label">{{ __('fields.id') }}</label>
            <div class="col-sm-9">
                <input type="number" class="form-control" id="inputId" name="id" disabled
                    value="{{old('id', $user->id)}}">
            </div>
        </div>
    @endif
    <div class="form-group row">
        <label for="inputFirstName" class="col-sm-3 col-form-label">{{ __('fields.first_name') }}</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="inputFirstName" name="first_name" placeholder="{{ __('fields.first_name') }}"
                value="{{ old('first_name', $user->first_name) }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="inputLastName" class="col-sm-3 col-form-label">{{ __('fields.last_name') }}</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="inputLastName" name="last_name" placeholder="{{ __('fields.last_name') }}"
                value="{{ old('last_name', $user->last_name) }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="inputEmail" class="col-sm-3 col-form-label">{{ __('fields.email') }}</label>
        <div class="col-sm-9">
            <input type="email" class="form-control" id="inputEmail" name="email" placeholder="{{ __('fields.email') }}"
                value="{{ old('email', $user->email) }}"
                aria-describedby="emailHelpBlock">
            <small id="emailHelpBlock" class="form-text text-muted">
                {{ __('auth.email_requirements') }}
            </small>
        </div>
    </div>
    <div class="form-group row">
        <label for="inputPhone" class="col-sm-3 col-form-label">{{ __('fields.phone') }}</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="inputPhone" name="phone" placeholder="{{ __('fields.phone') }}"
                value="{{ old('phone', $user->phone) }}">
        </div>
    </div>
    @if(Auth::user()->isAdmin() && Auth::user()->id != $user->id)
        <div class="form-group row">
            <label for="inputRole" class="col-sm-3 col-form-label">{{ __('fields.role') }}</label>
            <div class="col-sm-9">
                <select class="form-control chosen-select" id="inputRole" name="role">
                    @php($roleValue = intval(old('role', ($user->role ?? 0))));
                    @foreach(\App\Enums\UserRole::toArray() as $label => $value)
                    <option value="{{ $value }}" @if($roleValue === $value) selected @endif>{{ __('vocabulary.role.'.$label) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    @else
        <h2 class="mb-3 text-center">{{ __('actions.edit_password') }}</h2>
        <h5 class="text-center">{{ __('actions.edit_password_help') }}</h5>
        <div class="form-group row">
            <label for="inputPassword" class="col-sm-3 col-form-label">{{ __('fields.password') }}</label>
            <div class="col-sm-9">
                <input type="password" class="form-control" id="inputPassword" name="password" aria-describedby="passwordHelpBlock">
                <small id="passwordHelpBlock" class="form-text text-muted">
                    {{ __('auth.password_requirements') }}
                </small>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputPasswordConfirmation" class="col-sm-3 col-form-label">{{ __('fields.password_confirmation') }}</label>
            <div class="col-sm-9">
                <input type="password" class="form-control" id="inputPasswordConfirmation" name="password_confirmation">
            </div>
        </div>
    @endif
    <hr />
    <div class="form-group row">
        <div class="col-sm-9 offset-sm-3">
            <a href="{{ $cancelRoute ?? route('home') }}" class="btn btn-secondary">{{ __('actions.cancel') }}</a>
            <button type="submit" class="btn btn-primary">@svg('solid/save') {{ __('actions.'.$mode) }}</button>
        </div>
    </div>

</form>
@endsection
