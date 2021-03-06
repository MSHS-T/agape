@if(count($unsubmitted))
    <h2 class="mb-3 text-center">{{ __('actions.evaluationoffers.unsubmitted_count', ['count' => count($unsubmitted)]) }}</h2>
    <div class="row mb-3 justify-content-center">
        <div class="col-12">
            @foreach ($unsubmitted as $offer)
                <div class="row mb-1">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">
                                    {{ $offer->application->projectcall->toString() }} &rarr;
                                    {{ $offer->application->applicant->name }}
                                </h4>
                                <p class="card-text">
                                    <strong class="text-underline">{{ $offer->application->title }}</strong><br/>
                                    {!! $offer->application->short_description !!}
                                </p>
                                <a href="{{ route('evaluation.edit', ['evaluation' => $offer->evaluation]) }}" class="btn btn-warning">{{ __('actions.evaluation.correct')}}</a>
                            </div>
                            <div class="card-footer">
                                {{ __('fields.evaluation.devalidated_1') }}
                                <span class="font-weight-bold">
                                    "{{ $offer->evaluation->devalidation_message }}"
                                </span>
                                <br/>
                                {{ __('fields.evaluation.devalidated_2') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

@if(count($offers))
    <h2 class="mb-3 text-center">{{ __('actions.evaluationoffers.offer_count', ['count' => count($offers)]) }}</h2>
    <div class="row mb-3 justify-content-center">
        <div class="col-12">
            @foreach ($offers as $offer)
                <div class="row mb-1">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">
                                    {{ $offer->application->projectcall->toString() }} &rarr;
                                    {{ $offer->application->applicant->name }}
                                </h4>
                                <p class="card-text">
                                    <strong class="text-underline">{{ $offer->application->title }}</strong><br/>
                                    {!! $offer->application->short_description !!}
                                </p>
                                <a href="{{ route('offer.accept', ['offer' => $offer]) }}" class="btn btn-primary">{{ __('actions.accept')}}</a>
                                <a href="{{ route('offer.decline', ['offer' => $offer]) }}" class="btn btn-danger decline-link">{{ __('actions.decline')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

@if(count($accepted))
    <h2 class="mb-3 text-center">{{ __('actions.evaluationoffers.accepted_count', ['count' => count($accepted)]) }}</h2>
    <div class="row mb-3 justify-content-center">
        <div class="col-12">
            @foreach ($accepted as $offer)
                <div class="row mb-1">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">
                                    {{ $offer->application->projectcall->toString() }} &rarr;
                                    {{ $offer->application->applicant->name }}
                                </h4>
                                <p class="card-text">
                                    <strong class="text-underline">{{ $offer->application->title }}</strong><br/>
                                    {!! $offer->application->short_description !!}
                                </p>
                                <a href="{{ route('evaluation.edit', ['evaluation' => $offer->evaluation]) }}" class="btn btn-primary">{{ __('actions.evaluation.evaluate')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

@if(count($done))
    <h2 class="mb-3 text-center">{{ __('actions.evaluationoffers.done_count', ['count' => count($done)]) }}</h2>
    <div class="row mb-3 justify-content-center">
        <div class="col-12">
            @foreach ($done as $offer)
                <div class="row mb-1">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">
                                    {{ $offer->application->projectcall->toString() }} &rarr;
                                    {{ $offer->application->applicant->name }}
                                </h4>
                                <p class="card-text">
                                    <strong class="text-underline">{{ $offer->application->title }}</strong><br/>
                                    {!! $offer->application->short_description !!}
                                </p>
                                <a href="{{ route('evaluation.show', ['evaluation' => $offer->evaluation]) }}" class="btn btn-success">{{ __('actions.show')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

@if(!count($offers) && !count($accepted) && !count($done) && !count($unsubmitted))
    <h2 class="mb-3 text-center">{{ __('actions.evaluationoffers.empty') }}</h2>
@endif

<div class="modal fade" id="confirm-decline" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('actions.confirm_decline.title') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="{{__('actions.close')}}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="confirmation-form" action="" method="post">
                @csrf @method('POST')
                <div class="modal-body">
                    <p>
                        {{ __('actions.confirm_decline.body') }}
                        <br/>
                        <textarea id="justification" name="justification" class="w-100" rows="3"></textarea>
                        <br/>
                        <small id="justificationHelpBlock" class="text-danger invisible">
                            {{ __('actions.confirm_decline.error') }}
                        </small>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('actions.cancel') }}</button>
                    <button class="btn btn-danger" type="submit">{{ __('actions.decline') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $('.decline-link').click(function (e) {
            e.preventDefault();
            var targetUrl = $(this).attr('href');
            $("form#confirmation-form").attr('action', targetUrl);
            $('#justification').val("");
            $('#justificationHelpBlock').addClass("invisible").removeClass("visible");
            $(".modal#confirm-decline").modal();
            $("form#confirmation-form").on('submit', function(e){
                if($('#justification').val().trim() === ""){
                    e.preventDefault();
                    $('#justificationHelpBlock').addClass("visible").removeClass("invisible");
                    return false;
                }
            });
        });
    });

</script>
@endpush