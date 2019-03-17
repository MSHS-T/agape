@extends('layouts.app')
@section('content')
<h2 class="mb-3 text-center">
    {{ __('actions.application.show' . ($application->applicant_id != Auth::id() ? "_a" : "")) }}
</h2>
<h3 class="text-center">{{
    __('vocabulary.calltype_short.'.$application->projectcall->typeLabel) }} :
    {{$application->projectcall->year}}
</h3>
<h4 class="text-center">{{$application->projectcall->title}}</h4>
<p><u>{{ str_plural(__('fields.projectcall.application_period')) }} :</u> {{
    \Carbon\Carbon::parse($application->projectcall->application_start_date)->format(__('locale.date_format'))
    }}&nbsp;-&nbsp;{{
    \Carbon\Carbon::parse($application->projectcall->application_end_date)->format(__('locale.date_format')) }}
    <br />
    <u>{{ str_plural(__('fields.projectcall.evaluation_period')) }} :</u> {{
    \Carbon\Carbon::parse($application->projectcall->evaluation_start_date)->format(__('locale.date_format'))
    }}&nbsp;-&nbsp;{{
    \Carbon\Carbon::parse($application->projectcall->evaluation_end_date)->format(__('locale.date_format')) }}
</p>
<div class="application-display">
    <h2 class="text-center font-weight-bold border border-secondary rounded" id="form-section-1">
        {{ __('fields.application.form.section_1') }}
    </h2>
    <div class="row mb-3">
        <div class="col-3 font-weight-bold">
            {{ __('fields.application.title.' . $application->projectcall->typeLabel) }}
        </div>
        <div class="col-9">{{ $application->title }}</div>
    </div>
    <div class="row mb-3">
        <div class="col-3 font-weight-bold">{{ __('fields.application.acronym') }}</div>
        <div class="col-9">{{ $application->acronym }}</div>
    </div>
    <div class="row mb-3">
        <div class="col-3 font-weight-bold">
            {{ __('fields.application.carrier.' . $application->projectcall->typeLabel) }}
        </div>
        <div class="col-9">
            <div class="row">
                <div class="col-2"><b>{{ __('fields.name')}} : </b></div>
                <div class="col-4">{{ $application->carrier->name }}</div>
                <div class="col-2"><b>{{ __('fields.status') }} : </b></div>
                <div class="col-4">{{ $application->carrier->status }}</div>
            </div>
            <div class="row">
                <div class="col-2"><b>{{ __('fields.email')}} : </b></div>
                <div class="col-4">{{ $application->carrier->email }}</div>
                <div class="col-2"><b>{{ __('fields.phone')}} : </b></div>
                <div class="col-4">{{ $application->carrier->phone }}</div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-3 font-weight-bold">
            {{ __('fields.application.laboratories') }}
        </div>
        <div class="col-9">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">{{ __('fields.name') }}</th>
                        <th scope="col">{{ __('fields.laboratory.unit_code') }}</th>
                        <th scope="col">{{ __('fields.laboratory.director_email') }}</th>
                        <th scope="col">{{ __('fields.laboratory.regency') }}</th>
                        <th scope="col">{{ __('fields.laboratory.contact_name') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($application->laboratories as $laboratory)
                    <tr>
                        <th scope="row">{{ $laboratory->name }}</th>
                        <td>{{ $laboratory->unit_code }}</td>
                        <td>{{ $laboratory->directory_email }}</td>
                        <td>{{ $laboratory->regency }}</td>
                        <td>{{ $laboratory->pivot->contact_name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @if($application->projectcall->typeLabel == "Workshop")
    <div class="row mb-3">
        <div class="col-3 font-weight-bold">{{ __('fields.application.target_date') }}</div>
        <div class="col-9">@foreach($application->target_date as $date)
        {{ \Carbon\Carbon::parse($date)->format(__('locale.date_format')) }}<br/>
        @endforeach</div>
    </div>
    @else
    <div class="row mb-3">
        <div class="col-3 font-weight-bold">{{ __('fields.application.duration') }}</div>
        <div class="col-9">{{ $application->duration }}</div>
    </div>
    @endif
    <div class="row mb-3">
        <div class="col-3 font-weight-bold">{{ __('fields.application.study_fields') }}</div>
        <div class="col-9">
            <ul>
                @foreach($application->studyFields as $sf)
                <li>{{ $sf->name }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-3 font-weight-bold">{{ __('fields.application.summary_fr') }}</div>
        <div class="col-9">{!! $application->summary_fr !!}</div>
    </div>
    <div class="row mb-3">
        <div class="col-3 font-weight-bold">{{ __('fields.application.summary_en') }}</div>
        <div class="col-9">{!! $application->summary_en !!}</div>
    </div>
    <div class="row mb-3">
        <div class="col-3 font-weight-bold">{{ __('fields.application.keywords') }}</div>
        <div class="col-9">
            <ul>
                @foreach($application->keywords as $kw)
                <li>{{ $kw }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    <h2 class="text-center font-weight-bold border border-secondary rounded" id="form-section-2">
        {{ __('fields.application.form.section_2.'.$application->projectcall->typeLabel) }}
    </h2>
    <div class="row mb-3">
        <div class="col-3 font-weight-bold">{{ __('fields.application.short_description.' .
            $application->projectcall->typeLabel) }}</div>
        <div class="col-9">{!! $application->short_description !!}</div>
    </div>
    <h2 class="text-center font-weight-bold border border-secondary rounded" id="form-section-3">
        {{ __('fields.application.form.section_3.'.$application->projectcall->typeLabel) }}
    </h2>
    <div class="row mb-3">
        <div class="col-3 font-weight-bold">{{ __('fields.application.amount_requested') }}</div>
        <div class="col-9">{{ $application->amount_requested . " " . __('locale.currency') }}</div>
    </div>
    <div class="row mb-3">
        <div class="col-3 font-weight-bold">{{ __('fields.application.other_fundings') }}</div>
        <div class="col-9">{{ $application->other_fundings . " " . __('locale.currency') }}</div>
    </div>
    <div class="row mb-3">
        <div class="col-3 font-weight-bold">{{ __('fields.application.total_expected_income') }}</div>
        <div class="col-9">{{ $application->total_expected_income . " " . __('locale.currency') }}</div>
    </div>
    <div class="row mb-3">
        <div class="col-3 font-weight-bold">{{ __('fields.application.total_expected_outcome') }}</div>
        <div class="col-9">{{ $application->total_expected_outcome . " " . __('locale.currency') }}</div>
    </div>
    <h2 class="text-center font-weight-bold border border-secondary rounded" id="form-section-4">
        {{ __('fields.application.form.section_4') }}
    </h2>
    <div class="row mb-3">
        <div class="col-3 font-weight-bold">{{ __('fields.application.template.prefix.application') }}</div>
        <div class="col-9">
            {{ __('fields.download_link') }} :
            <a href="{{ route('download.attachment', ['application_id' => $application->id, 'index' => 1]) }}" target="_blank"
                rel="noopener">{{ $application->files[0]->name }}</a>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-3 font-weight-bold">{{ __('fields.application.template.prefix.financial') }}</div>
        <div class="col-9">
            {{ __('fields.download_link') }} :
            <a href="{{ route('download.attachment', ['application_id' => $application->id, 'index' => 2]) }}" target="_blank"
                rel="noopener">{{ $application->files[1]->name }}</a>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-3 font-weight-bold">{{ __('fields.application.other_attachments') }}</div>
        <div class="col-9">
            @foreach($application->files as $f)
            @continue($f->order <= 2) {{ __('fields.download_link') }} : <a href="{{ route('download.attachment', ['application_id' => $application->id, 'index' => $f->order]) }}"
                target="_blank" rel="noopener">{{ $f->name }}</a>
                @if(!$loop->last) <br /> @endif
                @endforeach
        </div>
    </div>
    @include('partials.back_button')
</div>
@endsection
