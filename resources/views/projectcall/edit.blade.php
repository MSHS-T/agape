@extends('layouts.app')
@section('content')
<h2 class="mb-3 text-center">{{ __('actions.projectcall.'.$mode) }}</h2>
<form method="<?php echo (in_array(strtoupper($method), ['GET', 'POST']) ? $method : 'POST'); ?>" action="{{ $action }}">
    @csrf @method($method)
    <div class="form-group row">
        <label for="type" class="col-sm-3 col-form-label">{{ __('fields.projectcall.type') }}</label>
        <div class="col-sm-9">
            @foreach (\App\Enums\CallType::toArray() as $type_key => $type_value)
            <div class="form-check">
                <input type="radio" name="type" id="type{{ $type_value }}" value="{{ $type_value }}" autocomplete="off"
                    {{ $type_value == old('type', $projectcall->type) ? "checked" : "disabled"}}>
                <label class="form-check-label" for="type{{ $type_value }}">{{ __('vocabulary.calltype.'.$type_key) }}</label>
            </div>
            @endforeach
        </div>
    </div>
    <div class="form-group row">
        <label for="inputYear" class="col-sm-3 col-form-label">{{ __('fields.projectcall.year') }}</label>
        <div class="col-sm-9">
            <input type="number" class="form-control" id="inputYear" name="year" placeholder="{{ __('fields.projectcall.year') }}"
                min="{{ \Carbon\Carbon::now()->year }}" value="{{ old('year', $projectcall->year) }}"
                {{ $mode!="create" ? "readonly" : "" }}>
        </div>
    </div>
    <div class="form-group row">
        <label for="inputTitle" class="col-sm-3 col-form-label">{{ __('fields.projectcall.title') }}</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="inputTitle" name="title" placeholder="{{ __('fields.projectcall.title') }}"
                value="{{ old('title', $projectcall->title) }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="inputDescription" class="col-sm-3 col-form-label">{{ __('fields.projectcall.description') }}</label>
        <div class="col-sm-9">
            <textarea class="form-control" id="inputDescription" name="description" rows="10" placeholder="{{ __('fields.projectcall.description') }}">{{ old('description', $projectcall->description) }}</textarea>
        </div>
    </div>
    <div class="form-group row text-left">
        <label for="inputApplicationPeriod" class="col-sm-3 col-form-label">{{
            __('fields.projectcall.application_period') }}</label>
        <div class="col-sm-4">
            <input type="date" class="form-control form-datepicker" id="inputApplicationPeriod" name="application_start_date"
                value="{{ old('application_start_date', $projectcall->application_start_date) }}">
        </div>
        <div class="col-sm-1 col-form-label">&nbsp;au&nbsp;</div>
        <div class="col-sm-4">
            <input type="date" class="form-control form-datepicker" id="inputApplicationPeriod2" name="application_end_date"
                value="{{ old('application_end_date', $projectcall->application_end_date) }}">
        </div>
    </div>
    <div class="form-group row text-left">
        <label for="inputEvaluationPeriod" class="col-sm-3 col-form-label">{{
            __('fields.projectcall.evaluation_period') }}</label>
        <div class="col-sm-4">
            <input type="date" class="form-control form-datepicker" id="inputEvaluationPeriod" name="evaluation_start_date"
                value="{{ old('evaluation_start_date', $projectcall->evaluation_start_date) }}">
        </div>
        <div class="col-sm-1 col-form-label">&nbsp;au&nbsp;</div>
        <div class="col-sm-4">
            <input type="date" class="form-control form-datepicker" id="inputEvaluationPeriod2" name="evaluation_end_date"
                value="{{ old('evaluation_end_date', $projectcall->evaluation_end_date) }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="inputNbExperts" class="col-sm-3 col-form-label">{{ __('fields.projectcall.number_of_experts') }}</label>
        <div class="col-sm-9">
            <input type="number" class="form-control" id="inputNbExperts" name="number_of_experts" min="1" max="{{ \App\Setting::get('max_number_of_experts') }}"
                value="{{old('number_of_experts', $projectcall->number_of_experts)}}">
        </div>
    </div>
    <div class="form-group row">
        <label for="inputNbDocuments" class="col-sm-3 col-form-label">{{ __('fields.projectcall.number_of_documents')
            }}</label>
        <div class="col-sm-9">
            <input type="number" class="form-control" id="inputNbDocuments" name="number_of_documents" min="1" max="{{ \App\Setting::get('max_number_of_documents') }}"
                value="{{old('number_of_documents', $projectcall->number_of_documents)}}">
        </div>
    </div>
    <div class="form-group row">
        <label for="inputPrivacyClause" class="col-sm-3 col-form-label">{{ __('fields.projectcall.privacy_clause') }}</label>
        <div class="col-sm-9">
            <textarea class="form-control" id="inputPrivacyClause" name="privacy_clause" rows="10" placeholder="{{ __('fields.projectcall.privacy_clause') }}">{{ old('privacy_clause', $projectcall->privacy_clause) }}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <label for="inputInvitationFr" class="col-sm-3 col-form-label">{{ __('fields.projectcall.invite_email_fr') }}</label>
        <div class="col-sm-9">
            <textarea class="form-control" id="inputInvitationFr" name="invite_email_fr" rows="10" placeholder="{{ __('fields.projectcall.invite_email_fr') }}">{{ old('invite_email_fr', $projectcall->invite_email_fr) }}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <label for="inputInvitationEn" class="col-sm-3 col-form-label">{{ __('fields.projectcall.invite_email_en') }}</label>
        <div class="col-sm-9">
            <textarea class="form-control" id="inputInvitationEn" name="invite_email_en" rows="10" placeholder="{{ __('fields.projectcall.invite_email_en') }}">{{ old('invite_email_en', $projectcall->invite_email_en) }}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <label for="inputHelpExpert" class="col-sm-3 col-form-label">{{ __('fields.projectcall.help_experts') }}</label>
        <div class="col-sm-9">
            <textarea class="form-control" id="inputHelpExpert" name="help_experts" rows="10" placeholder="{{ __('fields.projectcall.help_experts') }}">{{ old('help_experts', $projectcall->help_experts) }}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <label for="inputHelpCandidates" class="col-sm-3 col-form-label">{{ __('fields.projectcall.help_candidates') }}</label>
        <div class="col-sm-9">
            <textarea class="form-control" id="inputHelpCandidates" name="help_candidates" rows="10" placeholder="{{ __('fields.projectcall.help_candidates') }}">{{ old('help_candidates', $projectcall->help_candidates) }}</textarea>
        </div>
    </div>
    <hr />
    <div class="form-group row">
        <div class="col-sm-9 offset-sm-3">
            <a href="{{ route('projectcall.index') }}" class="btn btn-secondary">{{ __('actions.cancel') }}</a>
            <button type="submit" class="btn btn-primary">@svg('solid/check') {{ __('actions.'.$mode) }}</button>
        </div>
    </div>
</form>
@endsection
