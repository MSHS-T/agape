@extends('layouts.app') 
@section('content')
<form method="POST" action="{{ route('projectcall.store') }}">
    <div class="form-group row">
        <label for="type" class="col-sm-3 col-form-label">{{ __('fields.projectcall.type') }}</label>
        <div class="col-sm-9">
            <div class="form-check">
                <input type="radio" name="type" id="type1" value="1" autocomplete="off" {{old( 'type', 1)==1 ? "checked" : ''}}>
                <label class="form-check-label" for="type1">{{ __('vocabulary.calltype.Region') }}</label>
            </div>
            <div class="form-check">
                <input type="radio" name="type" id="type2" value="2" autocomplete="off" {{old( 'type', 1)==2 ? "checked" : ''}}>
                <label class="form-check-label" for="type2">{{ __('vocabulary.calltype.Exploratoire') }}</label>
            </div>
            <div class="form-check">
                <input type="radio" name="type" id="type3" value="3" autocomplete="off" {{old( 'type', 1)==3 ? "checked" : ''}}>
                <label class="form-check-label" for="type3">{{ __('vocabulary.calltype.Workshop') }}</label>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="inputYear" class="col-sm-3 col-form-label">{{ __('fields.projectcall.year') }}</label>
        <div class="col-sm-9">
            <input type="number" class="form-control" id="inputYear" name="year" placeholder="{{ __('fields.projectcall.year') }}" min="{{ \Carbon\Carbon::now()->year }}"
                value="{{ old('year', \Carbon\Carbon::now()->year) }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="inputDescription" class="col-sm-3 col-form-label">{{ __('fields.projectcall.description') }}</label>
        <div class="col-sm-9">
            <textarea class="form-control" id="inputDescription" name="description" rows="10" placeholder="{{ __('fields.projectcall.description') }}">{{ old('description', '') }}</textarea>
        </div>
    </div>
    <div class="form-group row text-left">
        <label for="inputApplicationPeriod" class="col-sm-3 col-form-label">{{ __('fields.projectcall.application_period') }}</label>
        <div class="col-sm-4">
            <input type="date" class="form-control form-datepicker" id="inputApplicationPeriod" name="application_start_date" value="{{ old('application_start_date', '') }}">
        </div>
        <div class="col-sm-1 col-form-label">&nbsp;au&nbsp;</div>
        <div class="col-sm-4">
            <input type="date" class="form-control form-datepicker" id="inputApplicationPeriod2" name="application_start_date" value="{{ old('application_start_date', '') }}">
        </div>
    </div>
    <div class="form-group row text-left">
        <label for="inputEvaluationPeriod" class="col-sm-3 col-form-label">{{ __('fields.projectcall.evaluation_period') }}</label>
        <div class="col-sm-4">
            <input type="date" class="form-control form-datepicker" id="inputEvaluationPeriod" name="evaluation_start_date" value="{{ old('evaluation_start_date', '') }}">
        </div>
        <div class="col-sm-1 col-form-label">&nbsp;au&nbsp;</div>
        <div class="col-sm-4">
            <input type="date" class="form-control form-datepicker" id="inputEvaluationPeriod2" name="evaluation_start_date" value="{{ old('evaluation_start_date', '') }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="inputNbExperts" class="col-sm-3 col-form-label">{{ __('fields.projectcall.number_of_experts') }}</label>
        <div class="col-sm-9">
            <input type="number" class="form-control" id="inputNbExperts" name="number_of_experts" min="1" max="{{ $max_number_of_experts }}"
                value="{{old('number_of_experts', 1)}}">
        </div>
    </div>
    <div class="form-group row">
        <label for="inputNbDocuments" class="col-sm-3 col-form-label">{{ __('fields.projectcall.number_of_documents') }}</label>
        <div class="col-sm-9">
            <input type="number" class="form-control" id="inputNbDocuments" name="number_of_documents" min="1" max="{{ $max_number_of_documents }}"
                value="{{old('number_of_documents', 1)}}">
        </div>
    </div>
    <div class="form-group row">
        <label for="inputPrivacyClause" class="col-sm-3 col-form-label">{{ __('fields.projectcall.privacy_clause') }}</label>
        <div class="col-sm-9">
            <textarea class="form-control" id="inputPrivacyClause" name="privacy_clause" rows="10" placeholder="{{ __('fields.projectcall.privacy_clause') }}">{{ old('privacy_clause', '') }}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <label for="inputInvitationFr" class="col-sm-3 col-form-label">{{ __('fields.projectcall.invite_email_fr') }}</label>
        <div class="col-sm-9">
            <textarea class="form-control" id="inputInvitationFr" name="invite_email_fr" rows="10" placeholder="{{ __('fields.projectcall.invite_email_fr') }}">{{ old('invite_email_fr', '') }}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <label for="inputInvitationEn" class="col-sm-3 col-form-label">{{ __('fields.projectcall.invite_email_en') }}</label>
        <div class="col-sm-9">
            <textarea class="form-control" id="inputInvitationEn" name="invite_email_en" rows="10" placeholder="{{ __('fields.projectcall.invite_email_en') }}">{{ old('invite_email_en', '') }}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <label for="inputHelpExpert" class="col-sm-3 col-form-label">{{ __('fields.projectcall.help_experts') }}</label>
        <div class="col-sm-9">
            <textarea class="form-control" id="inputHelpExpert" name="help_experts" rows="10" placeholder="{{ __('fields.projectcall.help_experts') }}">{{ old('help_experts', '') }}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <label for="inputHelpCandidates" class="col-sm-3 col-form-label">{{ __('fields.projectcall.help_candidates') }}</label>
        <div class="col-sm-9">
            <textarea class="form-control" id="inputHelpCandidates" name="help_candidates" rows="10" placeholder="{{ __('fields.projectcall.help_candidates') }}">{{ old('help_candidates', '') }}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-9 offset-sm-3">
            <button type="submit" class="btn btn-primary">@svg('solid/check') {{ __('actions.create') }}</button>
        </div>
    </div>
</form>
@endsection