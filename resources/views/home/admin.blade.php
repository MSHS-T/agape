<h2 class="mb-3 text-center">{{ __('actions.projectcall.listopen') }}</h2>
<div class="row justify-content-center">
    @php
        $today = \Carbon\Carbon::parse('today')->format('Y-m-d');
    @endphp
    @forelse($projectcalls as $call)
        <div class="col-4">
            <div class="card text-center" style="min-height: 17rem;">
                <div class="card-body">
                    <h3 class="card-title">
                        {{ $call->type->label_short . ' - ' . $call->year }}
                    </h3>
                    <div class="card-text">
                        <h4>{{ $call->title }}</h4>
                        <p>
                            @include('partials.projectcall_dates', ['projectcall' => $call])
                        </p>
                        <div class="d-flex flex-column align-items-stretch">
                            <a href="{{ route('projectcall.show', $call) }}" class="btn btn-primary d-inline-block my-1">
                                @svg('solid/search', 'icon-fw') {{ __('actions.show') }}
                            </a>
                            @php
                                $can_apply = $today >= $call->application_start_date;
                                $can_evaluate = $today >= $call->evaluation_start_date;
                            @endphp
                            @if ($can_apply)
                                <a href="{{ route('projectcall.applications', ['projectcall' => $call]) }}" class="btn btn-info d-inline-block my-1">
                                    @svg('solid/link', 'icon-fw')
                                    {{ __('actions.application.list_count', ['count' => count($call->submittedApplications)]) }}
                                </a>
                            @endif
                            @if ($can_evaluate)
                                <a href="{{ route('projectcall.evaluations', ['projectcall' => $call]) }}"
                                    class="btn btn-success d-inline-block my-1">
                                    @svg('solid/graduation-cap', 'icon-fw')
                                    {{ __('actions.evaluation.list_count', ['count' => $call->evaluationCount]) }} </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <h3 class="mb-3 text-center">{{ __('actions.projectcall.empty') }}</h3>
    @endforelse
</div>
