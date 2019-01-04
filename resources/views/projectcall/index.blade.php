@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <h2 class="mb-3">{{ __('actions.projectcall.list') }}</h2>
    <table class="table table-striped table-hover table-bordered list-table">
        <thead>
            <tr>
                <th>{{ __('fields.id') }}</th>
                <th>{{ __('fields.projectcall.type') }}</th>
                <th>{{ __('fields.projectcall.year') }}</th>
                <th>{{ __('fields.projectcall.title') }}</th>
                <th>{{ __('fields.projectcall.state') }}</th>
                <th>{{ __('fields.projectcall.calendar') }}</th>
                <th>{{ __('fields.creation_date') }}</th>
                <th>{{ __('fields.modification_date') }}</th>
                <th data-orderable="false">{{ __('fields.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($projectcalls as $call)
            @php($statestring = 'fields.projectcall.states.'.(empty($call->deleted_at) ? 'open' : 'archived'))
            <tr>
                <td>{{$call->id}}</td>
                <td>{{ __('vocabulary.calltype_short.'.\App\Enums\CallType::getKey($call->type)) }}</td>
                <td class="text-center">{{$call->year}}</td>
                <td>{{$call->title}}</td>
                <td class="text-center" data-search="{{ __($statestring) }}" data-toggle="tooltip" data-placement="right"
                    title="{{ __($statestring) }}">
                    @if (!empty($call->deleted_at)) @svg('solid/door-closed', 'icon-lg icon-fw')
                    @else @svg('solid/door-open', 'icon-lg icon-fw')
                    @endif
                </td>
                <td>
                    <u>{{ str_plural(__('fields.projectcall.application')) }} :</u><br />{{
                    \Carbon\Carbon::parse($call->application_start_date)->format(__('locale.date_format'))
                    }}&nbsp;-&nbsp;{{
                    \Carbon\Carbon::parse($call->application_end_date)->format(__('locale.date_format')) }}<br />
                    <u>{{ str_plural(__('fields.projectcall.evaluation')) }} :</u><br />{{
                    \Carbon\Carbon::parse($call->evaluation_start_date)->format(__('locale.date_format'))
                    }}&nbsp;-&nbsp;{{
                    \Carbon\Carbon::parse($call->evaluation_end_date)->format(__('locale.date_format')) }}
                </td>
                <td>{{ \Carbon\Carbon::parse($call->created_at)->format(__('locale.datetime_format'))}}</td>
                <td>{{ \Carbon\Carbon::parse($call->updated_at)->format(__('locale.datetime_format'))}}</td>
                <td>
                    <a href="
                    {{ route('projectcall.show',$call->id)}}" class="btn btn-sm btn-primary d-block">
                        @svg('solid/search', 'icon-fw') {{ __('actions.show') }}
                    </a>
                    @if (empty($call->deleted_at))
                    <a href="{{ route('projectcall.edit',$call->id)}}" class="btn btn-sm btn-warning d-block">
                        @svg('solid/edit', 'icon-fw') {{ __('actions.edit') }}
                    </a>
                    <a href="{{ route('projectcall.destroy', $call->id)}}" class="btn btn-sm btn-danger d-block archive-link">
                        @svg('solid/trash', 'icon-fw') {{ __('actions.archive') }}
                    </a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="row">
    <div class="col-12">
        <a href="{{ route('projectcall.create')}}" class="btn btn-success">
            @svg('solid/plus-square', 'icon-fw') {{ __('actions.projectcall.create') }}
        </a>
    </div>
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

@section('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
        $('.archive-link').click(function (e) {
            e.preventDefault();
            var targetUrl = jQuery(this).attr('href');
            $("form#confirmation-form").attr('action', targetUrl);
            $(".modal#confirm-archive").modal();
        });
        $('.list-table').DataTable({
            autoWidth: true,
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
@endsection
