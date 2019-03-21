@extends('layouts.app')
@section('content')
<h2 class="text-center mb-3">{{ __('actions.application.list') }}</h2>
<h3 class="text-center">{{
    __('vocabulary.calltype_short.'.$projectcall->typeLabel) }} :
    {{$projectcall->year}}
</h3>
<h4 class="text-center">{{$projectcall->title}}</h4>
<p><u>{{ str_plural(__('fields.projectcall.application_period')) }} :</u> {{
    \Carbon\Carbon::parse($projectcall->application_start_date)->format(__('locale.date_format'))
    }}&nbsp;-&nbsp;{{
    \Carbon\Carbon::parse($projectcall->application_end_date)->format(__('locale.date_format')) }}
    <br />
    <u>{{ str_plural(__('fields.projectcall.evaluation_period')) }} :</u> {{
    \Carbon\Carbon::parse($projectcall->evaluation_start_date)->format(__('locale.date_format'))
    }}&nbsp;-&nbsp;{{
    \Carbon\Carbon::parse($projectcall->evaluation_end_date)->format(__('locale.date_format')) }}
</p>
<div class="row justify-content-center">
    <table class="table table-striped table-hover table-bordered w-100" id="application_list">
        <thead>
            <tr>
                <th>{{ __('fields.id') }}</th>
                <th>{{ __('fields.projectcall.applicant') }}</th>
                <th>{{ __('fields.creation_date') }}</th>
                <th>{{ __('fields.submission_date') }}</th>
                <th>{{ __('fields.application.experts') }}</th>
                <th data-orderable="false">{{ __('fields.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($applications as $application)
            <tr>
                <td>{{ $application->id}}</td>
                <td>{{ $application->applicant->name }}</td>
                <td>
                    {{ \Carbon\Carbon::parse($application->created_at)->format(__('locale.datetime_format'))}}
                </td>
                <td>
                    {{ \Carbon\Carbon::parse($application->submitted_at)->format(__('locale.datetime_format'))}}
                </td>
                <td>
                    @if(!empty($application->offers))
                        <ul>
                            @foreach($application->offers as $offer)
                                <li>
                                    {{ $offer->expert->name }}
                                    @if(is_null($offer->accepted))
                                        @svg('solid/question', 'icon-fw text-primary')
                                    @elseif($offer->accepted == true)
                                        @svg('solid/check', 'icon-fw text-success')
                                    @elseif($offer->accepted == false)
                                        @svg('solid/times', 'icon-fw text-danger')
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </td>
                <td>
                    <a href="
                    {{ route('application.show',$application->id)}}" class="btn btn-sm btn-primary d-block">
                        @svg('solid/search', 'icon-fw') {{ __('actions.show') }}
                    </a>
                    <a href="
                    {{ route('application.assignations',$application->id)}}" class="btn btn-sm btn-success d-block">
                        @svg('solid/user-graduate', 'icon-fw') {{ __('actions.application.show_experts') }}
                    </a>
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
                [3, 'desc']
            ],
            columns: [null, null, null, null, null, {
                searchable: false
            }],
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
