@extends('layouts.app')
@section('content')
<h2 class="mb-3 text-center">{{ __('actions.settings.list') }}</h2>

<form method="POST" action="{{ route('settings.update') }}" id="settings_form" enctype="multipart/form-data">
    @csrf @method("POST")

    <h2 class="text-center font-weight-bold border border-secondary rounded">
        {{ __('actions.settings.sections.projectcalls') }}
    </h2>
    @include('forms.textinput', [
        'name'  => 'default_number_of_target_dates',
        'label' => __('fields.setting.default_number_of_target_dates'),
        'value' => old('default_number_of_target_dates', $settings->default_number_of_target_dates),
        'type'  => 'number',
        'step'  => 1,
        'help' => __('fields.setting.help.default_value')
    ])
    @include('forms.textinput', [
        'name'  => 'default_number_of_experts',
        'label' => __('fields.setting.default_number_of_experts'),
        'value' => old('default_number_of_experts', $settings->default_number_of_experts),
        'type'  => 'number',
        'step'  => 1,
        'help' => __('fields.setting.help.default_value')
    ])
    @include('forms.textinput', [
        'name'  => 'default_number_of_documents',
        'label' => __('fields.setting.default_number_of_documents'),
        'value' => old('default_number_of_documents', $settings->default_number_of_documents),
        'type'  => 'number',
        'step'  => 1,
        'help' => __('fields.setting.help.default_value')
    ])
    @include('forms.textinput', [
        'name'  => 'default_number_of_laboratories',
        'label' => __('fields.setting.default_number_of_laboratories'),
        'value' => old('default_number_of_laboratories', $settings->default_number_of_laboratories),
        'type'  => 'number',
        'step'  => 1,
        'help' => __('fields.setting.help.default_value')
    ])
    @include('forms.textinput', [
        'name'  => 'default_number_of_study_fields',
        'label' => __('fields.setting.default_number_of_study_fields'),
        'value' => old('default_number_of_study_fields', $settings->default_number_of_study_fields),
        'type'  => 'number',
        'step'  => 1,
        'help' => __('fields.setting.help.default_value')
    ])
    @include('forms.textinput', [
        'name'  => 'default_number_of_keywords',
        'label' => __('fields.setting.default_number_of_keywords'),
        'value' => old('default_number_of_keywords', $settings->default_number_of_keywords),
        'type'  => 'number',
        'step'  => 1,
        'help' => __('fields.setting.help.default_value')
    ])
    @include('forms.textinput', [
        'name'  => 'extensions_application_form',
        'label' => __('fields.setting.extensions_application_form'),
        'value' => old('extensions_application_form', $settings->extensions_application_form)
    ])
    @include('forms.textinput', [
        'name'  => 'extensions_financial_form',
        'label' => __('fields.setting.extensions_financial_form'),
        'value' => old('extensions_financial_form', $settings->extensions_financial_form)
    ])
    @include('forms.textinput', [
        'name'  => 'extensions_other_attachments',
        'label' => __('fields.setting.extensions_other_attachments'),
        'value' => old('extensions_other_attachments', $settings->extensions_other_attachments)
    ])

    <h2 class="text-center font-weight-bold border border-secondary rounded">
        {{ __('actions.settings.sections.notation_guide') }}
    </h2>
    @foreach(range(1,3) as $index => $iteration)
        @include('forms.textinput', [
            'name'  => 'notation_'.$iteration.'_title',
            'label' => __('fields.setting.notation_title', ['index' => $iteration]),
            'value' => old(
                'notation_'.$iteration.'_title',
                $settings->{'notation_'.$iteration.'_title'}
            )
        ])
        @include('forms.textarea', [
            'name'  => 'notation_'.$iteration.'_description',
            'label' => __('fields.setting.notation_description', ['index' => $iteration]),
            'value' => old(
                'notation_'.$iteration.'_description',
                $settings->{'notation_'.$iteration.'_description'}
            )
        ])
    @endforeach
    <h2 class="text-center font-weight-bold border border-secondary rounded">
        {{ __('actions.settings.sections.notation_description') }}
    </h2>
    @foreach(range(0,3) as $index)
        @include('forms.textinput', [
            'name'  => 'notation_grid_'.$index.'_grade',
            'label' => __('fields.setting.notation_grade', ['grade' => $index]),
            'value' => old(
                'notation_grid_'.$index.'_grade',
                json_decode($settings->notation_grid, true)[$index]['grade']
            )
        ])
        @include('forms.textinput', [
            'name'  => 'notation_grid_'.$index.'_details',
            'label' => __('fields.setting.notation_details'),
            'value' => old(
                'notation_grid_'.$index.'_details',
                json_decode($settings->notation_grid, true)[$index]['details']
            )
        ])
    @endforeach

    <hr />
    <div class="form-group row">
        <div class="col-sm-12 text-center">
            <a href="{{ route('home') }}" class="btn btn-secondary">{{ __('actions.cancel') }}</a>
            <button type="submit" name="save" class="btn btn-primary">@svg('solid/save') {{ __('actions.save') }}</button>
        </div>
    </div>
</form>
@endsection
