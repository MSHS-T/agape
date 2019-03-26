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
<div class="row justify-content-center">
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
                    {{ $notation_grid[$evaluation->grade1]['grade'] }}
                </td>
                <td>
                    {!! $evaluation->comment1 !!}
                </td>
                <td data-order="{{ $evaluation->grade2 }}">
                    {{ $notation_grid[$evaluation->grade2]['grade'] }}
                </td>
                <td>
                    {!! $evaluation->comment2 !!}
                </td>
                <td data-order="{{ $evaluation->grade3 }}">
                    {{ $notation_grid[$evaluation->grade3]['grade'] }}
                </td>
                <td>
                    {!! $evaluation->comment3 !!}
                </td>
                <td data-order="{{ $evaluation->global_grade }}">
                    {{ $notation_grid[$evaluation->global_grade]['grade'] }}
                </td>
                <td>
                    {!! $evaluation->global_comment !!}
                </td>
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
        $('#application_list').DataTable({
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
