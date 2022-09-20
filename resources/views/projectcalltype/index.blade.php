@extends('layouts.app')
@section('content')
    <h2 class="mb-3 text-center">{{ __('actions.project_call_type.list') }}</h2>
    <div class="row justify-content-center">
        <table class="table table-striped table-hover table-bordered w-100" id="projectcalltype_list">
            <thead>
                <tr>
                    <th>{{ __('fields.id') }}</th>
                    <th>{{ __('fields.projectcalltype.reference') }}</th>
                    <th>{{ __('fields.projectcalltype.label_short') }}</th>
                    <th>{{ __('fields.projectcalltype.label_long') }}</th>
                    <th>{{ __('fields.projectcalltype.is_workshop') }}</th>
                    <th data-orderable="false">{{ __('fields.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projectcalltypes as $type)
                    <tr>
                        <td>{{ $type->id }}</td>
                        <td>{{ $type->reference }}</td>
                        <td>{{ $type->label_short }}</td>
                        <td>{{ $type->label_long }}</td>
                        <td>{{ $type->is_workshop ? __('fields.yes') : __('fields.no') }}</td>
                        <td>
                            <a href="{{ route('projectcalltype.edit', $type) }}" class="btn btn-sm btn-warning d-block">
                                @svg('solid/edit', 'icon-fw') {{ __('actions.edit') }}
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="row mt-1">
        <a href="{{ route('projectcalltype.create') }}" class="btn btn-success">
            @svg('solid/plus-square', 'icon-fw') {{ __('actions.create') }}
        </a>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            $('#projectcalltype_list').DataTable({
                autoWidth: false,
                lengthChange: true,
                searching: true,
                ordering: true,
                order: [
                    [1, 'asc']
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
