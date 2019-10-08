@extends('layouts.app')
@section('content')
<h2 class="mb-3 text-center">{{ __('actions.user.list') }}</h2>
<div class="row justify-content-center">
    <table class="table table-striped table-hover table-bordered w-100" id="user_list">
        <thead>
            <tr>
                <th>{{ __('fields.id') }}</th>
                <th>{{ __('fields.last_name') }}</th>
                <th>{{ __('fields.first_name') }}</th>
                <th>{{ __('fields.email') }}</th>
                <th>{{ __('fields.phone') }}</th>
                <th>{{ __('fields.role') }}</th>
                <th>{{ __('fields.user.registration_date') }}</th>
                <th>{{ __('fields.user.last_login_date') }}</th>
                <th>{{ __('fields.status') }}</th>
                <th data-orderable="false">{{ __('fields.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->last_name }}</td>
                    <td>{{ $user->first_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>
                        {{ __('vocabulary.role.' . App\Enums\UserRole::getKey($user->role)) }}
                    </td>
                    <td data-order="{{ $user->created_at }}">
                        @date(['datetime' => $user->created_at])
                    </td>
                    <td data-order="{{ $user->updated_at ?? 0 }}">
                        @date(['datetime' => $user->updated_at])
                    </td>
                    <td
                        class="text-center"
                        data-search="{{ __('fields.user.'.($user->deleted_at ? 'blocked' : 'unblocked')) }}"
                        data-toggle="tooltip"
                        data-placement="right"
                        title="{{ __('fields.user.'.($user->deleted_at ? 'blocked' : 'unblocked')) }}"
                    >
                        @if(!is_null($user->deleted_at))
                            @svg('solid/lock', 'icon-fw text-danger')
                        @else
                            @svg('solid/lock-open', 'icon-fw')
                        @endif
                    </td>
                    <td>
                         @php
                            if(!is_null($user->deleted_at)) {
                                $icon = "solid/lock-open";
                                $text = __('actions.user.unblock');
                                $color = "success";
                            }
                            else {
                                $icon = "solid/lock";
                                $text = __('actions.user.block');
                                $color = "warning";
                            }
                        @endphp
                        <a href="{{ route('user.block', $user)}}" class="btn btn-sm btn-{{ $color }} d-block block-link" data-buttontext="{{ $text }}" data-buttoncolor="{{ $color }}">
                            @svg($icon, 'icon-fw') {{ $text }}
                        </a>
                        <a href="{{ route('user.destroy', $user)}}" class="btn btn-sm btn-danger d-block delete-link" data-buttontext="{{ __('actions.delete') }}" data-buttoncolor="danger">
                            @svg('solid/trash', 'icon-fw') {{ __('actions.delete') }}
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="row justify-content-center">
    <div class="col-6 jumbotron">
        <h4 class="text-center pb-2">{{ __('actions.user.invite') }}</h4>
        <form method="POST" action="{{ route('user.store') }}" id="invitation_form">
            @csrf @method("POST")
            @include('forms.textinput', [
                'name'  => 'email',
                'label' => __('fields.email'),
                'value' => old('email', '')
            ])
            @include('forms.select', [
                'name' => 'role',
                'label' => __('fields.role'),
                'allowedValues' => \App\Enums\UserRole::toSelectArray(),
                'allowNone' => false,
                'allowNew' => false,
                'multiple' => false,
                'displayField' => 'label',
                'valueField' => 'value'
            ])
            <p class="text-center">
                <button type="submit" name="save" class="btn btn-primary">@svg('solid/plus') {{ __('actions.add') }}</button>
            </p>
        </form>
    </div>
</div>

<div class="modal fade" id="confirm-block" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('actions.confirm_block.title') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="{{__('actions.close')}}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{ __('actions.confirm_block.body') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('actions.cancel') }}</button>
                <form id="confirmation-form" action="" method="post">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger" type="submit">{{ __('actions.block') }}</button>
                </form>
            </div>
        </div>
    </div>
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
        $('.block-link').click(function (e) {
            e.preventDefault();
            var targetUrl = jQuery(this).attr('href');
            var text = jQuery(this).attr('data-buttontext');
            var color = jQuery(this).attr('data-buttoncolor');
            $("form#confirmation-form").attr('action', targetUrl);
            $("form#confirmation-form").find('button[type=submit]')
                                       .text(text)
                                       .removeClass()
                                       .addClass('btn btn-'+color);

            $(".modal#confirm-block").modal();
        });
        $('.delete-link').click(function (e) {
            e.preventDefault();
            var targetUrl = jQuery(this).attr('href');
            var text = jQuery(this).attr('data-buttontext');
            var color = jQuery(this).attr('data-buttoncolor');
            $("form#confirmation-form").attr('action', targetUrl);
            $("form#confirmation-form").find('button[type=submit]')
                                       .text(text)
                                       .removeClass()
                                       .addClass('btn btn-'+color);

            $(".modal#confirm-delete").modal();
        });
        $('#user_list').DataTable({
            autoWidth: false,
            lengthChange: true,
            searching: true,
            ordering: true,
            order: [
                [6, 'desc']
            ],
            columns: [null, null, null, null, null, null, null, null, null, {
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
