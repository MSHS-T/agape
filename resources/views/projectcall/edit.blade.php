@extends('layouts.app')
@php($tabindex = 0)
@section('content')
    <h2 class="mb-3 text-center">{{ __('actions.projectcall.' . $mode) }}</h2>
    <form method="<?php echo in_array(strtoupper($method), ['GET', 'POST']) ? $method : 'POST'; ?>" action="{{ $action }}" enctype="multipart/form-data">
        @csrf @method($method)
        <div class="form-group row">
            <label for="type" class="col-sm-3 col-form-label">{{ __('fields.projectcall.type') }}</label>
            <div class="col-sm-9">
                @foreach ($allowedTypes as $typeId => $typeLabel)
                    <div class="form-check">
                        <input type="radio" name="project_call_type_id" id="type{{ $typeId }}" value="{{ $typeId }}" autocomplete="off"
                            {{ $typeId == old('type', $projectcall->project_call_type_id ?? null) ? 'checked' : ($mode == 'edit' ? 'disabled' : '') }}
                            tabindex="{{ ++$tabindex }}">
                        <label class="form-check-label" for="type{{ $typeId }}">{{ $typeLabel }}</label>
                    </div>
                @endforeach
            </div>
        </div>
        @include('forms.textinput', [
            'name' => 'year',
            'label' => __('fields.projectcall.year'),
            'value' => old('year', $projectcall->year),
            'type' => 'number',
            'step' => 1,
            'min' => \Carbon\Carbon::now()->year,
            'readonly' => $mode != 'create',
            'tabindex' => ++$tabindex,
        ])
        @include('forms.textinput', [
            'name' => 'title',
            'label' => __('fields.projectcall.title'),
            'value' => old('title', $projectcall->title),
            'tabindex' => ++$tabindex,
        ])
        @include('forms.textarea', [
            'name' => 'description',
            'label' => __('fields.projectcall.description'),
            'value' => old('description', $projectcall->description),
            'tabindex' => ++$tabindex,
        ])
        @include('forms.daterange', [
            'name' => ['application_start_date', 'application_end_date'],
            'label' => __('fields.projectcall.application_period'),
            'value' => [
                old('application_start_date', $projectcall->application_start_date),
                old('application_end_date', $projectcall->application_end_date),
            ],
            'tabindex' => ++$tabindex,
        ])
        @include('forms.daterange', [
            'name' => ['evaluation_start_date', 'evaluation_end_date'],
            'label' => __('fields.projectcall.evaluation_period'),
            'value' => [
                old('evaluation_start_date', $projectcall->evaluation_start_date),
                old('evaluation_end_date', $projectcall->evaluation_end_date),
            ],
            'tabindex' => ++$tabindex,
        ])
        @include('forms.textinput', [
            'name' => 'number_of_experts',
            'label' => __('fields.projectcall.number_of_experts'),
            'value' => old('number_of_experts', $projectcall->number_of_experts),
            'type' => 'number',
            'step' => 1,
            'min' => 1,
            'tabindex' => ++$tabindex,
        ])
        @include('forms.textinput', [
            'name' => 'number_of_documents',
            'label' => __('fields.projectcall.number_of_documents'),
            'value' => old('number_of_documents', $projectcall->number_of_documents),
            'type' => 'number',
            'step' => 1,
            'min' => 1,
            'tabindex' => ++$tabindex,
        ])
        @include('forms.textinput', [
            'name' => 'number_of_keywords',
            'label' => __('fields.projectcall.number_of_keywords'),
            'value' => old('number_of_keywords', $projectcall->number_of_keywords),
            'type' => 'number',
            'step' => 1,
            'min' => 1,
            'tabindex' => ++$tabindex,
        ])
        @include('forms.textinput', [
            'name' => 'number_of_laboratories',
            'label' => __('fields.projectcall.number_of_laboratories'),
            'value' => old('number_of_laboratories', $projectcall->number_of_laboratories),
            'type' => 'number',
            'step' => 1,
            'min' => 1,
            'tabindex' => ++$tabindex,
        ])
        @include('forms.textinput', [
            'name' => 'number_of_study_fields',
            'label' => __('fields.projectcall.number_of_study_fields'),
            'value' => old('number_of_study_fields', $projectcall->number_of_study_fields),
            'type' => 'number',
            'step' => 1,
            'min' => 1,
            'tabindex' => ++$tabindex,
        ])
        @include('forms.textinput', [
            'name' => 'number_of_target_dates',
            'label' => __('fields.projectcall.number_of_target_dates'),
            'value' => old('number_of_target_dates', $projectcall->number_of_target_dates),
            'type' => 'number',
            'step' => 1,
            'min' => 1,
            'tabindex' => ++$tabindex,
        ])

        @include('forms.textarea', [
            'name' => 'privacy_clause',
            'label' => __('fields.projectcall.privacy_clause'),
            'value' => old('privacy_clause', $projectcall->privacy_clause),
            'tabindex' => ++$tabindex,
        ])
        @include('forms.textarea', [
            'name' => 'invite_email_fr',
            'label' => __('fields.projectcall.invite_email_fr'),
            'value' => old('invite_email_fr', $projectcall->invite_email_fr),
            'help' => __('fields.projectcall.invite_email_help'),
            'tabindex' => ++$tabindex,
        ])
        @include('forms.textarea', [
            'name' => 'invite_email_en',
            'label' => __('fields.projectcall.invite_email_en'),
            'value' => old('invite_email_en', $projectcall->invite_email_en),
            'help' => __('fields.projectcall.invite_email_help'),
            'tabindex' => ++$tabindex,
        ])
        @include('forms.textarea', [
            'name' => 'help_candidates',
            'label' => __('fields.projectcall.help_candidates'),
            'value' => old('help_candidates', $projectcall->help_candidates),
            'tabindex' => ++$tabindex,
        ])
        @include('forms.textarea', [
            'name' => 'help_experts',
            'label' => __('fields.projectcall.help_experts'),
            'value' => old('help_experts', $projectcall->help_experts),
            'tabindex' => ++$tabindex,
        ])
        <div class="form-group row">
            <label for="inputApplicationFormFilepath" class="col-3 col-form-label">
                {{ __('fields.application.template.prefix.application') }}
            </label>
            <div class="col-9">
                @if (isset($projectcall->id) && !empty($projectcall->application_form_filepath))
                    {{ __('fields.download_link') }} :
                    <a href="{{ route('projectcall.template', ['projectcall' => $projectcall, 'template' => 'application']) }}" target="_blank"
                        rel="noopener">{{ __('actions.download') }}</a>
                    <br />
                @endif
                <input type="file" id="inputApplicationFormFilepath" name="application_form"
                    accept="{{ \App\Setting::get('extensions_application_form') }}">
                <small id="inputApplicationFormFilepathHelpBlock" class="form-text text-muted">
                    {{ __('fields.upload_extensions') }} : {{ str_replace(',', ', ', \App\Setting::get('extensions_application_form')) }}<br />
                    {!! __('fields.upload_overwrite') !!}
                </small>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputFinancialFormFilepath" class="col-3 col-form-label">
                {{ __('fields.application.template.prefix.financial') }}
            </label>
            <div class="col-9">
                @if (isset($projectcall->id) && !empty($projectcall->financial_form_filepath))
                    {{ __('fields.download_link') }} :
                    <a href="{{ route('projectcall.template', ['projectcall' => $projectcall, 'template' => 'financial']) }}" target="_blank"
                        rel="noopener">{{ __('actions.download') }}</a>
                    <br />
                @endif
                <input type="file" id="inputFinancialFormFilepath" name="financial_form"
                    accept="{{ \App\Setting::get('extensions_financial_form') }}">
                <small id="inputFinancialFormFilepathHelpBlock" class="form-text text-muted">
                    {{ __('fields.upload_extensions') }} : {{ str_replace(',', ', ', \App\Setting::get('extensions_financial_form')) }}<br />
                    {!! __('fields.upload_overwrite') !!}
                </small>
            </div>
        </div>

        <h2 class="text-center font-weight-bold border border-secondary rounded">
            {{ __('actions.settings.sections.notation_guide') }}
        </h2>
        @foreach (range(1, 3) as $index => $iteration)
            @include('forms.textinput', [
                'name' => 'notation_' . $iteration . '_title',
                'label' => __('fields.setting.notation_title', ['index' => $iteration]),
                'value' => old('notation_' . $iteration . '_title', $settings->{'notation_' . $iteration . '_title'}),
                'tabindex' => ++$tabindex,
            ])
            @include('forms.textarea', [
                'name' => 'notation_' . $iteration . '_description',
                'label' => __('fields.setting.notation_description', ['index' => $iteration]),
                'value' => old('notation_' . $iteration . '_description', $settings->{'notation_' . $iteration . '_description'}),
                'tabindex' => ++$tabindex,
            ])
        @endforeach

        <hr />
        <div class="form-group row">
            <div class="col-sm-9 offset-sm-3">
                <a href="{{ route('projectcall.index') }}" class="btn btn-secondary">{{ __('actions.cancel') }}</a>
                <button type="submit" class="btn btn-primary">@svg('solid/check') {{ __('actions.' . $mode) }}</button>
            </div>
        </div>
    </form>
@endsection
