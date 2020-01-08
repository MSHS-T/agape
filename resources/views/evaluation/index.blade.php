@extends('layouts.app')
@php($projectcall = $projectcall ?? $application->projectcall)
@php($notation_grid = json_decode(\App\Setting::get('notation_grid'), true))
@section('content')
<h2 class="text-center mb-3">{{ __('actions.evaluation.list_count', ['count' => count($evaluations)]) }}</h2>
<h3 class="text-center">{{
    __('vocabulary.calltype_short.'.$projectcall->typeLabel) }} :
    {{$projectcall->year}}
    <br/>
    <small>{{ $projectcall->title }}</small>
</h3>
@if(isset($application))
    <h4 class="text-center">{{ __('fields.projectcall.applicant') }} : {{ $application->applicant->name }}</h4>
@endif
<div class="row mb-3">
    <div class="col-12 table-buttons">
        @if(isset($application))
            @php($link=route('application.evaluationsExport', ['application'=>$application]))
        @else
            @php($link=route('projectcall.evaluationsExport', ['projectcall'=>$projectcall]))
        @endif
        <a href="{{$link}}" class="btn btn-secondary">{{ __('actions.export_pdf') }}</a>
        <a href="{{$link}}?anonymized=1" class="btn btn-secondary">{{ __('actions.export_pdf_anon') }}</a>
    </div>
</div>
<div class="row d-flex flex-column align-content-stretch">
    <table class="table table-striped table-hover table-bordered w-100" id="application_list">
        <thead>
            <tr>
                <th>{{ __('fields.id') }}</th>
                @if(!isset($application))
                    <th>{{ __('fields.projectcall.applicant') }}</th>
                @endif
                <th>{{ __('fields.offer.expert') }}</th>
                <th>{{ __('fields.evaluation.grade') }} 1</th>
                <th>{{ __('fields.comments') }} 1</th>
                <th>{{ __('fields.evaluation.grade') }} 2</th>
                <th>{{ __('fields.comments') }} 2</th>
                <th>{{ __('fields.evaluation.grade') }} 3</th>
                <th>{{ __('fields.comments') }} 3</th>
                <th>{{ __('fields.evaluation.global_grade') }}</th>
                <th>{{ __('fields.evaluation.global_comment') }}</th>
                <th>{{ __('fields.submission_date') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($evaluations as $evaluation)
            <tr>
                <td>{{ $evaluation->id }}</td>
                @if(!isset($application))
                    <td>{{ $evaluation->offer->application->applicant->name }}</td>
                @endif
                <td>
                    {{ $evaluation->offer->expert->name }}
                </td>
                <td data-order="{{ $evaluation->grade1 }}">
                    {{ $evaluation->grade1 !== null ? $notation_grid[$evaluation->grade1]['grade'] : '?' }}
                </td>
                <td>
                    {!! $evaluation->comment1 !!}
                </td>
                <td data-order="{{ $evaluation->grade2 }}">
                    {{ $evaluation->grade2 !== null ? $notation_grid[$evaluation->grade2]['grade'] : '?' }}
                </td>
                <td>
                    {!! $evaluation->comment2 !!}
                </td>
                <td data-order="{{ $evaluation->grade3 }}">
                    {{ $evaluation->grade3 !== null ? $notation_grid[$evaluation->grade3]['grade'] : '?' }}
                </td>
                <td>
                    {!! $evaluation->comment3 !!}
                </td>
                <td data-order="{{ $evaluation->global_grade }}">
                    {{ $evaluation->global_grade !== null ? $notation_grid[$evaluation->global_grade]['grade'] : '?' }}
                </td>
                <td>
                    {!! $evaluation->global_comment !!}
                </td>
                <td>@date(['datetime' => $evaluation->submitted_at])</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@include('partials.back_button', ['url' => route('projectcall.index')])
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        var dt = $('#application_list').DataTable({
            lengthChange: true,
            searching: true,
            ordering: true,
            order: [
                [0, 'desc']
            ],
            language: @json(__('datatable')),
            pageLength: 5,
            lengthMenu: [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "@lang('datatable.all')"]
            ]
        });
    });

</script>
@endpush
