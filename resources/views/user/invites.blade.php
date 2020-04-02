@extends('layouts.app')
@section('content')
<h2 class="mb-3 text-center">{{ __('actions.user.invite_list') }}</h2>
<div class="row justify-content-center">
    <table class="table table-striped table-hover table-bordered w-100" id="user_list">
        <thead>
            <tr>
                <th>{{ __('fields.email') }}</th>
                <th>{{ __('fields.role') }}</th>
                <th>{{ __('fields.user.invitation_date') }}</th>
                <th data-orderable="false">{{ __('fields.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invitations as $invitation)
                <tr>
                    <td>{{ $invitation->email }}</td>
                    <td>
                        {{ __('vocabulary.role.' . App\Enums\UserRole::getKey($invitation->role)) }}
                    </td>
                    <td data-order="{{ $invitation->updated_at }}">
                        @date(['datetime' => $invitation->updated_at])
                    </td>
                    <td>
                        <a href="{{ route('user.invite.retry', $invitation->invitation)}}" class="btn btn-sm btn-danger d-block resend-link" data-buttontext="{{ __('actions.resend') }}" data-buttoncolor="danger">
                            @svg('solid/reply-all', 'icon-fw') {{ __('actions.resend') }}
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="modal fade" id="confirm-resend" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('actions.confirm_resend.title') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="{{__('actions.close')}}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{ __('actions.confirm_resend.body') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('actions.cancel') }}</button>
                <form id="confirmation-form" action="" method="post">
                    @csrf
                    <button class="btn btn-danger" type="submit">{{ __('actions.send') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $('.resend-link').click(function (e) {
            e.preventDefault();
            var targetUrl = jQuery(this).attr('href');
            var text = jQuery(this).attr('data-buttontext');
            var color = jQuery(this).attr('data-buttoncolor');
            $("form#confirmation-form").attr('action', targetUrl);
            $("form#confirmation-form").find('button[type=submit]')
                                       .text(text)
                                       .removeClass()
                                       .addClass('btn btn-'+color);

            $(".modal#confirm-resend").modal();
        });
        $('#user_list').DataTable({
            autoWidth: true,
            lengthChange: true,
            searching: true,
            ordering: true,
            order: [
                [2, 'desc']
            ],
            columns: [null, null, null, {
                searchable: false
            }],
            language: @json(__('datatable')),
            pageLength: 10,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "@lang('datatable.all')"]
            ]
        });
    });

</script>
@endpush
