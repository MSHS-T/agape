@extends('layouts.app')
@section('content')
<h2 class="text-center mb-3">{{ __('actions.application.list') }}</h2>
<h3 class="text-center">
    {{ $projectcall->toString() }}
</h3>
<p>
    @include('partials.projectcall_dates', ['projectcall' => $projectcall])
</p>
<div class="row mb-3">
    <div class="col-12 table-buttons">
        <a class="btn btn-info" href="{{ route('projectcall.applicationsExport', ['projectcall' => $projectcall]) }}">
            @svg('solid/file-excel', 'icon-fw')
            {{ __('exports.buttons.excel') }}
        </a>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-12">
        <table class="table table-striped table-hover table-bordered" id="application_list" style="width:100%;">
            <thead>
                <tr>
                    <th>{{ __('fields.reference') }}</th>
                    <th>{{ __('fields.application.acronym') }}</th>
                    <th>{{ __('fields.projectcall.applicant') }}</th>
                    <th>{{ __('fields.application.laboratory_1') }}</th>
                    <th>{{ __('fields.submission_date') }}</th>
                    <th>{{ __('fields.application.experts') }}</th>
                    <th data-orderable="false">{{ __('fields.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($applications as $application)
                <tr>
                    <td>{{ $application->reference}}</td>
                    <td>{{ $application->acronym}}</td>
                    <td>{{ $application->applicant->name }}</td>
                    <td>{{ $application->carrierLaboratory->first()->name ?? '' }}</td>
                    <td data-sort="{{$application->submitted_at ?? 0}}">
                        @date(['datetime' => $application->submitted_at])
                    </td>
                    <td>
                        @if(!empty($application->offers))
                        <ul>
                            @foreach($application->offers as $offer)
                            <li>
                                {{ $offer->expert->name ?? $offer->invitedExpert->email }}
                                @if(is_null($offer->accepted))
                                @svg('solid/question', 'icon-fw text-info')
                                @elseif($offer->accepted == true)
                                @if(!is_null($offer->evaluation) && !is_null($offer->evaluation->submitted_at))
                                @svg('solid/check', 'icon-fw text-success')
                                @else
                                @svg('solid/hourglass', 'icon-fw text-primary')
                                @endif
                                @elseif($offer->accepted == false)
                                <span data-toggle="tooltip" data-placement="bottom" data-html="true"
                                    title="<b><u>{{ __('fields.offer.justification') }}:</u></b> {{$offer->justification}}">
                                    @svg('solid/times', 'icon-fw text-danger')
                                </span>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('application.show',$application)}}" class="btn btn-sm btn-primary d-block">
                            @svg('solid/search', 'icon-fw') {{ __('actions.show') }}
                        </a>
                        @if($application->submitted_at == null)
                        <a href="{{ route('application.forceSubmit',$application)}}"
                            class="btn btn-sm btn-warning d-block force-submission-link">
                            @svg('solid/check') {{ __('actions.application.force_submit') }}
                        </a>
                        <a href="{{ route('application.destroy',$application)}}"
                            class="btn btn-sm btn-danger d-block destroy-link">
                            @svg('solid/trash') {{ __('actions.application.destroy') }}
                        </a>
                        @else
                        <a href="{{ route('application.unsubmit',$application)}}"
                            class="btn btn-sm btn-danger d-block unsubmit-link">
                            @svg('solid/backspace') {{ __('actions.application.unsubmit') }}
                        </a>
                        <a href="{{ route('application.assignations',$application)}}"
                            class="btn btn-sm btn-success d-block">
                            @svg('solid/user-graduate', 'icon-fw') {{ __('actions.application.experts') }}
                        </a>
                        <a href="{{ route('application.evaluations',$application)}}"
                            class="btn btn-sm btn-light d-block">
                            @svg('solid/graduation-cap', 'icon-fw') {{ __('actions.application.evaluations') }}
                        </a>
                        <a href="{{ route('application.comityOpinion',$application)}}"
                            class="btn btn-sm btn-info d-block comity-opinion-link"
                            data-textarea="{{ $application->selection_comity_opinion ?? '' }}">
                            @svg(
                            'solid/users',
                            'icon-fw ' . ($application->selection_comity_opinion !== null ? 'text-dark' : 'text-light')
                            ) {{ __('actions.application.comity_opinion') }}
                        </a>
                        @endif

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@include('partials.back_button', ['url' => route('projectcall.index')])

<div class="modal fade" id="confirm-force-submission" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('actions.application.confirm_force_submission.title') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="{{__('actions.close')}}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{ __('actions.application.confirm_force_submission.body') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('actions.cancel') }}</button>
                <form id="confirmation-form" action="" method="post">
                    @csrf @method('PUT')
                    <button class="btn btn-warning" type="submit">
                        @svg('solid/check') {{ __('actions.application.force_submit') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="confirm-destroy" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('actions.application.confirm_destroy.title') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="{{__('actions.close')}}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{ __('actions.application.confirm_destroy.body') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('actions.cancel') }}</button>
                <form id="confirmation-form" action="" method="post">
                    @csrf @method('PUT')
                    <button class="btn btn-danger" type="submit">
                        @svg('solid/check') {{ __('actions.application.destroy') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="confirm-unsubmit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('actions.application.confirm_unsubmit.title') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="{{__('actions.close')}}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="devalidation-form" action="" method="post">
                @csrf @method('PUT')
                <div class="modal-body">
                    <p>
                        {{ __('actions.application.confirm_unsubmit.body') }}
                        <br />
                        <textarea id="justification" name="justification" class="w-100" rows="3"></textarea>
                        <br />
                        <small id="justificationHelpBlock" class="text-danger invisible">
                            {{ __('actions.application.confirm_unsubmit.error') }}
                        </small>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('actions.cancel')
                        }}</button>
                    <button class="btn btn-danger" type="submit">{{ __('actions.application.unsubmit') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="confirm-comity-opinion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-add">{{ __('actions.application.confirm_comity_opinion.title_add') }}</h5>
                <h5 class="modal-title text-edit">{{ __('actions.application.confirm_comity_opinion.title_edit') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="{{__('actions.close')}}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="comity-opinion-form" action="" method="post">
                @csrf @method('PUT')
                <div class="modal-body">
                    <p>
                        <textarea id="comityOpinion" name="comity_opinion" class="w-100" rows="8"></textarea>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('actions.cancel')
                        }}</button>
                    <button class="btn btn-danger" type="submit">
                        <span class="text-add">
                            {{ __('actions.save') }}
                        </span>
                        <span class="text-edit">
                            {{ __('actions.edit') }}
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $('.force-submission-link').click(function (e) {
            e.preventDefault();
            var targetUrl = jQuery(this).attr('href');
            $("form#confirmation-form").attr('action', targetUrl);
            $(".modal#confirm-force-submission").modal();
            return false;
        });
        $('.destroy-link').click(function (e) {
            e.preventDefault();
            var targetUrl = jQuery(this).attr('href');
            $("form#confirmation-form").attr('action', targetUrl);
            $(".modal#confirm-destroy").modal();
            return false;
        });

        $('.unsubmit-link').click(function (e) {
            e.preventDefault();
            var targetUrl = $(this).attr('href');
            $("form#devalidation-form").attr('action', targetUrl);
            $('#justification').val("");
            $('#justificationHelpBlock').addClass("invisible").removeClass("visible");
            $(".modal#confirm-unsubmit").modal();
            $("form#devalidation-form").on('submit', function(e){
                if($('#justification').val().trim() === ""){
                    e.preventDefault();
                    $('#justificationHelpBlock').addClass("visible").removeClass("invisible");
                    return false;
                }
            });
        });

        $('.comity-opinion-link').click(function (e) {
            e.preventDefault();
            var targetUrl = $(this).attr('href');
            var existingData = $(this).attr('data-textarea');
            $("form#comity-opinion-form").attr('action', targetUrl);
            $('#comityOpinion').val(existingData.replace(/<br\s*[\/]?>/gi, "\n"));
            $(".modal#confirm-comity-opinion").find('.text-add, .text-edit').hide();
            $(".modal#confirm-comity-opinion").find(
                (existingData !== "" ? '.text-edit' : '.text-add')
            ).show();
            $(".modal#confirm-comity-opinion").modal();
        });

        $('#application_list').DataTable({
            autoWidth   : false,
            lengthChange: true,
            searching   : true,
            ordering    : true,
            language    : @json(__('datatable')),
            pageLength  : 5,
            order       : [
                [4, 'desc']
            ],
            columns: [null, null, null,  null, null, { width: 300 }, {
                width     : 150,
                searchable: false
            }],
            lengthMenu: [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "@lang('datatable.all')"]
            ]
        });
    });

</script>
@endpush