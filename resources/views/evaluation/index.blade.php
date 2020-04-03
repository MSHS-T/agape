@extends('layouts.app')
@php($projectcall = $projectcall ?? $application->projectcall)
@php($notation_grid = json_decode(\App\Setting::get('notation_grid'), true))
@section('content')
<h2 class="text-center mb-3">{{ __('actions.evaluation.list_count', ['count' => count($evaluations)]) }}</h2>
<h3 class="text-center">{{
    __('vocabulary.calltype_short.'.$projectcall->typeLabel) }} :
    {{$projectcall->year}}
    <br/>
    <small>{{ $projectcall->title }}</small>
</h3>
@if(isset($application))
    <h4 class="text-center">{{ __('fields.projectcall.applicant') }} : {{ $application->applicant->name }}</h4>
    <h4 class="text-center">{{ __('fields.application.acronym') }} : {{ $application->acronym }}</h4>
@endif
<div class="row mb-3">
    <div class="col-12 table-buttons">
        @if(isset($application))
            @php($link=route('application.evaluationsExport', ['application'=>$application]))
        @else
            @php($link=route('projectcall.evaluationsExport', ['projectcall'=>$projectcall]))
        @endif
        <a href="{{$link}}" class="btn btn-secondary">{{ __('actions.export_pdf') }}</a>
        <a href="{{$link}}?anonymized=1" class="btn btn-secondary">{{ __('actions.export_pdf_anon') }}</a>
    </div>
</div>
<div class="row d-flex flex-column align-content-stretch">
    <table class="table table-striped table-hover table-bordered w-100" id="evaluation_list">
        <thead>
            <tr>
                <th>{{ __('fields.id') }}</th>
                @if(!isset($application))
                    <th>{{ __('fields.application.acronym') }}</th>
                    <th>{{ __('fields.projectcall.applicant') }}</th>
                @endif
                <th>{{ __('fields.offer.expert') }}</th>
                <th>{{ __('fields.evaluation.grade') }} 1</th>
                <th>{{ __('fields.comments') }} 1</th>
                <th>{{ __('fields.evaluation.grade') }} 2</th>
                <th>{{ __('fields.comments') }} 2</th>
                <th>{{ __('fields.evaluation.grade') }} 3</th>
                <th>{{ __('fields.comments') }} 3</th>
                <th>{{ __('fields.evaluation.global_grade') }}</th>
                <th>{{ __('fields.evaluation.global_comment') }}</th>
                <th>{{ __('fields.submission_date') }}</th>
                <th data-orderable="false">{{ __('fields.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($evaluations as $evaluation)
            <tr>
                <td>{{ $evaluation->id }}</td>
                @if(!isset($application))
                    <td>{{ $evaluation->offer->application->acronym }}</td>
                    <td>{{ $evaluation->offer->application->applicant->name }}</td>
                @endif
                <td>
                    {{ $evaluation->offer->expert->name }}
                </td>
                <td data-order="{{ $evaluation->grade1 }}">
                    {{ $evaluation->grade1 !== null ? $notation_grid[$evaluation->grade1]['grade'] : '?' }}
                </td>
                <td>
                    {!! \Illuminate\Support\Str::limit($evaluation->comment1, 100, ' (...)') !!}
                </td>
                <td data-order="{{ $evaluation->grade2 }}">
                    {{ $evaluation->grade2 !== null ? $notation_grid[$evaluation->grade2]['grade'] : '?' }}
                </td>
                <td>
                    {!! \Illuminate\Support\Str::limit($evaluation->comment2, 100, ' (...)') !!}
                </td>
                <td data-order="{{ $evaluation->grade3 }}">
                    {{ $evaluation->grade3 !== null ? $notation_grid[$evaluation->grade3]['grade'] : '?' }}
                </td>
                <td>
                    {!! \Illuminate\Support\Str::limit($evaluation->comment3, 100, ' (...)') !!}
                </td>
                <td data-order="{{ $evaluation->global_grade }}">
                    {{ $evaluation->global_grade !== null ? $notation_grid[$evaluation->global_grade]['grade'] : '?' }}
                </td>
                <td>
                    {!! \Illuminate\Support\Str::limit($evaluation->global_comment, 100, ' (...)') !!}
                </td>
                <td>@date(['datetime' => $evaluation->submitted_at])</td>
                <td>
                    <button type="button" class="btn btn-sm btn-secondary btn-block viewmore-link" data-evaluation="{{ $evaluation->id }}">
                        @svg('solid/search-plus', 'icon-fw') {{ __('actions.show_more') }}
                    </button>
                    <a href="{{ route('application.show',$evaluation->offer->application)}}" class="btn btn-sm btn-primary btn-block">
                        @svg('solid/link', 'icon-fw') {{ __('actions.application.one') }}
                    </a>
                    @if($evaluation->submitted_at == null)
                        <a href="{{ route('evaluation.forceSubmit',$evaluation)}}" class="btn btn-sm btn-warning btn-block force-submission-link">
                            @svg('solid/check') {{ __('actions.evaluation.force_submit') }}
                        </a>
                    @else
                        <a href="{{ route('evaluation.unsubmit',$evaluation)}}" class="btn btn-sm btn-danger btn-block unsubmit-link">
                            @svg('solid/backspace') {{ __('actions.evaluation.unsubmit') }}
                        </a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="d-none">
    @foreach($evaluations as $evaluation)
        <div id="evaluation-{{ $evaluation->id }}">
            @include('partials.evaluation_display', ["evaluation" => $evaluation, "anonymized" => false, "noId" => true, "criteriaDetails" => false])
        </div>
    @endforeach
</div>
<div class="modal fade" id="confirm-force-submission" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('actions.evaluation.confirm_force_submission.title') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="{{__('actions.close')}}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{ __('actions.evaluation.confirm_force_submission.body') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('actions.cancel') }}</button>
                <form id="confirmation-form" action="" method="post">
                    @csrf @method('PUT')
                    <button class="btn btn-warning" type="submit">
                        @svg('solid/check') {{ __('actions.evaluation.force_submit') }}
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
                <h5 class="modal-title">{{ __('actions.evaluation.confirm_unsubmit.title') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="{{__('actions.close')}}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="devalidation-form" action="" method="post">
                @csrf @method('PUT')
                <div class="modal-body">
                    <p>
                        {{ __('actions.evaluation.confirm_unsubmit.body') }}
                        <br/>
                        <textarea id="justification" name="justification" class="w-100" rows="3"></textarea>
                        <br/>
                        <small id="justificationHelpBlock" class="text-danger invisible">
                            {{ __('actions.evaluation.confirm_unsubmit.error') }}
                        </small>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('actions.cancel') }}</button>
                    <button class="btn btn-danger" type="submit">{{ __('actions.evaluation.unsubmit') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('partials.back_button', ['url' => route('projectcall.index')])
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

        var dt = $('#evaluation_list').DataTable({
            lengthChange: true,
            searching: true,
            ordering: true,
            order: [
                [0, 'desc']
            ],
            columns: [
                @if(!isset($application))
                /* Two extra columns if we are not listing the evaluation of a specific application */
                null, null,
                @endif
                null, null, null, null, null, null, null, null, null, null, null, {
                searchable: false,
                width: 110
            }],
            language: @json(__('datatable')),
            pageLength: 5,
            lengthMenu: [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "@lang('datatable.all')"]
            ]
        });

        // Add event listener for opening and closing details
        $('#evaluation_list').on('click', 'button.viewmore-link', function (e) {
            e.preventDefault();

            var tr = $(this).closest('tr');
            var row = dt.row( tr );
    
            if ( row.child.isShown() ) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                // Find the HTML
                var id = $(this).attr('data-evaluation');
                var contents = $('div#evaluation-'+id).html();
                // Open this row
                row.child(contents).show();
                tr.addClass('shown');
            }
            return false;
        });
    });

</script>
@endpush
