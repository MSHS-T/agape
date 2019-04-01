@extends('layouts.app')
@section('content')
<h2 class="mb-3 text-center">{{ __('actions.studyfield.list') }}</h2>
<div class="row justify-content-center">
    <table class="table table-striped table-hover table-bordered w-100" id="studyfield_list">
        <thead>
            <tr>
                <th>{{ __('fields.id') }}</th>
                <th>{{ __('fields.name') }}</th>
                <th>{{ __('fields.creator') }}</th>
                <th data-orderable="false">{{ __('fields.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($studyfields as $sf)
                <tr>
                    <td>{{ $sf->id }}</td>
                    <td>{{ $sf->name }}</td>
                    <td>{{ $sf->creator->name }}</td>
                    <td>
                        <a href="{{ route('studyfield.edit',$sf)}}" class="btn btn-sm btn-warning d-block">
                            @svg('solid/edit', 'icon-fw') {{ __('actions.edit') }}
                        </a>
                        <a href="{{ route('studyfield.destroy', $sf)}}" class="btn btn-sm btn-danger d-block delete-link">
                            @svg('solid/trash', 'icon-fw') {{ __('actions.delete') }}
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="row mt-1">
    <a href="{{ route('studyfield.create')}}" class="btn btn-success">
        @svg('solid/plus-square', 'icon-fw') {{ __('actions.create') }}
    </a>
</div>

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('actions.confirm_delete.title') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="{{__('actions.close')}}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{ __('actions.confirm_delete.body') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('actions.cancel') }}</button>
                <form id="confirmation-form" action="" method="post">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger" type="submit">{{ __('actions.delete') }}</button>
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
        $('.delete-link').click(function (e) {
            e.preventDefault();
            var targetUrl = jQuery(this).attr('href');
            $("form#confirmation-form").attr('action', targetUrl);
            $(".modal#confirm-delete").modal();
        });
        $('#studyfield_list').DataTable({
            autoWidth: false,
            lengthChange: true,
            searching: true,
            ordering: true,
            order: [
                [0, 'desc']
            ],
            columns: [null, null, null, {
                searchable: false
            }],
            language: @json(__('datatable')),
            pageLength: 10,
            lengthMenu: [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "@lang('datatable.all')"]
            ]
        });
    });

</script>
@endpush
