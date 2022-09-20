@extends('layouts.app')
@php($tabindex = 0)
@section('content')
    <h2 class="mb-3 text-center">{{ __('actions.project_call_type.' . $mode) }}</h2>
    <form method="<?php echo in_array(strtoupper($method), ['GET', 'POST']) ? $method : 'POST'; ?>" action="{{ $action }}">
        @csrf @method($method)
        @include('forms.textinput', [
            'name' => 'reference',
            'label' => __('fields.projectcalltype.reference'),
            'value' => old('reference', $project_call_type->reference),
            'tabindex' => ++$tabindex,
        ])
        @include('forms.textinput', [
            'name' => 'label_short',
            'label' => __('fields.projectcalltype.label_short'),
            'value' => old('label_short', $project_call_type->label_short),
            'tabindex' => ++$tabindex,
        ])
        @include('forms.textinput', [
            'name' => 'label_long',
            'label' => __('fields.projectcalltype.label_long'),
            'value' => old('label_long', $project_call_type->label_long),
            'tabindex' => ++$tabindex,
        ])
        <div class="form-group row">
            <label for="type" class="col-sm-3 col-form-label">{{ __('fields.projectcall.type') }}</label>
            <div class="col-sm-9">
                <div class="form-check">
                    <input type="checkbox" name="is_workshop" id="is_workshop" value="1"
                        {{ old('is_workshop', $project_call_type->is_workshop ?? false) ? 'checked' : '' }} tabindex="{{ ++$tabindex }}">
                    <label class="form-check-label" for="is_workshop">{{ __('fields.projectcalltype.is_workshop') }}</label>
                </div>
            </div>
        </div>

        <hr />
        <div class="form-group row">
            <div class="col-sm-9 offset-sm-3">
                <a href="{{ route('projectcalltype.index') }}" class="btn btn-secondary">{{ __('actions.cancel') }}</a>
                <button type="submit" class="btn btn-primary">@svg('solid/check') {{ __('actions.' . $mode) }}</button>
            </div>
        </div>
    </form>
@endsection
