@extends('layouts.app')
@section('content')
    <h2 class="text-center mb-3">{{ __('actions.application.assignations') }}</h2>
    <h3 class="text-center">{{ $application->projectcall->toString() }}
    </h3>
    <h4 class="text-center">{{ $application->projectcall->title }}</h4>
    <h5 class="text-center">
        <u>{{ __('fields.projectcall.applicant') }} :</u>
        {{ $application->applicant->name }}
    </h5>
    <h5 class="text-center mb-4">
        <u>{{ __('fields.submission_date') }} :</u>
        @date(['datetime' => $application->submitted_at])
    </h5>
    <div class="row justify-content-center">
        <table class="table table-striped table-hover table-bordered w-100" id="assignation_list">
            <thead>
                <tr>
                    <th>{{ __('fields.id') }}</th>
                    <th>{{ __('fields.offer.expert') }}</th>
                    <th>{{ __('fields.status') }}</th>
                    <th>{{ __('fields.creation_date') }}</th>
                    <th>{{ __('fields.offer.retries') }}</th>
                    @if ($application->projectcall->canEvaluate())
                        <th data-orderable="false">{{ __('fields.actions') }}</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @php($total = 0)
                @foreach ($application->offers as $offer)
                    <tr>
                        <td>{{ $offer->id }}</td>
                        <td>{{ $offer->expert->name ?? $offer->invitedExpert->email }}</td>
                        <td>
                            @if (is_null($offer->accepted))
                                @svg('solid/question', 'icon-fw text-info')
                                {{ __('fields.offer.pending') }}
                                @php($total++)
                            @elseif($offer->accepted == true)
                                @if (!is_null($offer->evaluation) && !is_null($offer->evaluation->submitted_at))
                                    @svg('solid/check', 'icon-fw text-success')
                                    {{ __('fields.offer.done') }}
                                @else
                                    @svg('solid/hourglass', 'icon-fw text-primary')
                                    {{ __('fields.offer.accepted') }}
                                @endif
                                @php($total++)
                            @elseif($offer->accepted == false)
                                @svg('solid/times', 'icon-fw text-danger')
                                {{ __('fields.offer.declined') }}
                                <br />
                                <b><u>{{ __('fields.offer.justification') }}:</u></b> {{ $offer->justification }}
                            @endif
                        </td>
                        <td>
                            {{ $offer->creator->name }}<br />
                            @date(['datetime' => $offer->created_at])
                        </td>
                        <td>
                            @foreach ($offer->retry_history as $r)
                                @date(['datetime' => $r])
                                @if (!$loop->last)
                                    <br />
                                @endif
                            @endforeach
                        </td>
                        @if ($application->projectcall->canEvaluate())
                            <td>
                                @if (is_null($offer->accepted) || ($offer->accepted == true && is_null($offer->evaluation)))
                                    <a href="{{ route('offer.retry', [$offer->id]) }}" class="btn btn-sm btn-warning btn-block">
                                        @svg('solid/sync', 'icon-fw') {{ __('actions.evaluationoffers.retry') }}
                                    </a>
                                @endif
                                @if (is_null($offer->accepted))
                                    <a href="{{ route('offer.destroy', ['offer' => $offer]) }}" class="btn btn-sm btn-danger btn-block delete-link">
                                        @svg('solid/times', 'icon-fw') {{ __('actions.cancel') }}
                                    </a>
                                @endif
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if ($application->projectcall->canEvaluate() && $total < $application->projectcall->number_of_experts)
        <div class="row justify-content-center">
            <div class="col-6 jumbotron">
                <h4 class="text-center pb-2">{{ __('actions.application.assign_expert') }}</h4>
                @if (count($experts) > 0)
                    <form method="POST" action="{{ route('offer.store', $application) }}" id="assignation_form">
                        @csrf @method('POST')
                        @include('forms.select', [
                            'name' => 'expert_id',
                            'label' => __('fields.application.experts_database'),
                            'allowedValues' => $experts,
                            'allowNone' => true,
                            'allowNew' => false,
                            'multiple' => false,
                            'displayField' => 'name',
                            'valueField' => 'id',
                        ])
                        <h4 class="text-center text-uppercase mb-3">
                            <span class="badge badge-danger">
                                {{ __('fields.or') }}
                            </span>
                        </h4>
                        @include('forms.textinput', [
                            'name' => 'expert_email',
                            'label' => __('fields.application.experts_invite'),
                            'value' => '',
                            'placeholder' => __('fields.email'),
                        ])
                        <p class="text-center">
                            <button type="submit" name="save" class="btn btn-primary">@svg('solid/plus')
                                {{ __('actions.add') }}</button>
                        </p>
                    </form>
                @else
                    <p class="text-danger text-center">
                        {{ __('fields.offer.no_experts') }}
                    </p>
                @endif
            </div>
        </div>
    @endif
    @include('partials.back_button', ['url' => route('projectcall.applications', ['projectcall' => $application->projectcall->id])])

    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('actions.confirm_delete.title') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('actions.close') }}">
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
        $(document).ready(function() {
            $('.delete-link').click(function(e) {
                e.preventDefault();
                var targetUrl = jQuery(this).attr('href');
                $("form#confirmation-form").attr('action', targetUrl);
                $(".modal#confirm-delete").modal();
            });
        });
    </script>
@endpush
