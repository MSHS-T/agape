@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <h2 class="mb-3">{{ __('actions.laboratory.list') }}</h2>
    <table class="table table-striped table-hover table-bordered w-100" id="laboratory_list">
        <thead>
            <tr>
                <th>{{ __('fields.id') }}</th>
                <th>{{ __('fields.name') }}</th>
                <th>{{ __('fields.laboratory.unit_code') }}</th>
                <th>{{ __('fields.laboratory.director_email') }}</th>
                <th>{{ __('fields.laboratory.regency') }}</th>
                <th>{{ __('fields.creator') }}</th>
                <th>{{ __('fields.creation_date') }}</th>
                <th>{{ __('fields.modification_date') }}</th>
                <th data-orderable="false">{{ __('fields.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laboratories as $lab)
                <tr>
                    <td>{{ $lab->id }}</td>
                    <td>{{ $lab->name }}</td>
                    <td>{{ $lab->unit_code }}</td>
                    <td>{{ $lab->director_email }}</td>
                    <td>{{ $lab->regency }}</td>
                    <td>{{ $lab->creator->name }}</td>
                    <td>@date(['datetime' => $lab->created_at])</td>
                    <td>@date(['datetime' => $lab->updated_at])</td>
                    <td>
                        <a href="{{ route('laboratory.edit',$lab)}}" class="btn btn-sm btn-warning d-block">
                            @svg('solid/edit', 'icon-fw') {{ __('actions.edit') }}
                        </a>
                        <a href="{{ route('laboratory.destroy', $lab)}}" class="btn btn-sm btn-danger d-block delete-link">
                            @svg('solid/trash', 'icon-fw') {{ __('actions.delete') }}
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="row mt-1">
    <a href="{{ route('laboratory.create')}}" class="btn btn-success">
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
        $('.delete-link').click(function (e) {
            e.preventDefault();
            var targetUrl = jQuery(this).attr('href');
            $("form#confirmation-form").attr('action', targetUrl);
            $(".modal#confirm-delete").modal();
        });
        $('#laboratory_list').DataTable({
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
