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
                <th data-orderable="false">{{ __('fields.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($projectcall->applications as $application)
            <tr>
                <td>{{ $application->id}}</td>
                <td>{{ $application->applicant->name }}</td>
                <td>
                    {{ \Carbon\Carbon::parse($application->created_at)->format(__('locale.date_format'))}}
                </td>
                <td>
                    {{ \Carbon\Carbon::parse($application->submitted_at)->format(__('locale.date_format'))}}
                </td>
                <td>
                    <a href="
                    {{ route('application.show',$application->id)}}" class="btn btn-sm btn-primary d-block">
                        @svg('solid/search', 'icon-fw') {{ __('actions.show') }}
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="modal fade" id="confirm-archive" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('actions.confirm_archive.title') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="{{__('actions.close')}}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{ __('actions.confirm_archive.body') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('actions.cancel') }}</button>
                <form id="confirmation-form" action="" method="post">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger" type="submit">{{ __('actions.archive') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
        $('.archive-link').click(function (e) {
            e.preventDefault();
            var targetUrl = jQuery(this).attr('href');
            $("form#confirmation-form").attr('action', targetUrl);
            $(".modal#confirm-archive").modal();
        });
        $('#projectcall_list').DataTable({
            autoWidth: false,
            lengthChange: true,
            searching: true,
            ordering: true,
            order: [
                [6, 'desc']
            ],
            columns: [null, null, null, null, null, null, null, null, {
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
