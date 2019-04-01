@extends('layouts.app')
@section('content')
<h2 class="text-center mb-3">{{ __('actions.application.list') }}</h2>
<h3 class="text-center">
    {{ $projectcall->toString() }}
</h3>
<p>
    @include('partials.projectcall_dates', ['projectcall' => $projectcall])
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
                                        @if(!is_null($offer->evaluation))
                                            @svg('solid/check', 'icon-fw text-success')
                                        @else
                                            @svg('solid/hourglass', 'icon-fw text-warning')
                                        @endif
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
                    {{ route('application.show',$application)}}" class="btn btn-sm btn-primary d-block">
                        @svg('solid/search', 'icon-fw') {{ __('actions.show') }}
                    </a>
                    <a href="
                    {{ route('application.assignations',$application)}}" class="btn btn-sm btn-success d-block">
                        @svg('solid/user-graduate', 'icon-fw') {{ __('actions.application.experts') }}
                    </a>
                    <a href="
                    {{ route('application.evaluations',$application)}}" class="btn btn-sm btn-light d-block">
                        @svg('solid/graduation-cap', 'icon-fw') {{ __('actions.application.evaluations') }}
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
