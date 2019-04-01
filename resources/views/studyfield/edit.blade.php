@extends('layouts.app')
@php($tabindex = 0)
@section('content')
<h2 class="mb-3 text-center">{{ __('actions.studyfield.'.$mode) }}</h2>
<form method="<?php echo (in_array(strtoupper($method), ['GET', 'POST']) ? $method : 'POST'); ?>" action="{{ $action }}">
    @csrf @method($method)
    @include('forms.textinput', [
        'name'     => 'name',
        'label'    => __('fields.name'),
        'value'    => old('name', $studyfield->name),
        'tabindex' => ++$tabindex
    ])

    @if(!is_null($studyfield->id ?? null) && !$studyfield->creator->isAdmin())
        @include('forms.textinput', [
            'name'     => 'creator',
            'label'    => __('fields.creator'),
            'value'    => $studyfield->creator->name,
            'tabindex' => -1,
            'disabled' => true
        ])
        <div class="form-group row">
            <div class="col-9 offset-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="make_public" id="make_public" {{ old( 'make_public') ? 'checked' : '' }}>

                    <label class="form-check-label" for="make_public">
                        {{ __('actions.make_public') }}
                    </label>
                </div>
            </div>
        </div>
    @endif

    <hr />
    <div class="form-group row">
        <div class="col-sm-9 offset-sm-3">
            <a href="{{ route('studyfield.index') }}" class="btn btn-secondary">{{ __('actions.cancel') }}</a>
            <button type="submit" class="btn btn-primary">@svg('solid/check') {{ __('actions.'.$mode) }}</button>
        </div>
    </div>
</form>
@endsection
