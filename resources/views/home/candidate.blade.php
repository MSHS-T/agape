@foreach(['unsubmitted' => $unsubmitted_applications, 'open' => $open_calls, 'old' => $old_calls] as $type => $projectcalls)
    @if($type == 'unsubmitted' && !count($projectcalls))
        @continue
    @endif
    <h2 class="mb-3 text-center">{{ __('actions.projectcall.list'.$type) }}</h2>
    @if(!count($projectcalls))
        <h5 class="mb-3 text-center">{{ __('actions.projectcall.empty') }}</h5>
    @else
        <div class="row justify-content-center">
            @foreach($projectcalls as $call)
            <div class="col-4">
                <div class="card text-center" style="min-height: 17rem;">
                    <div class="card-body">
                        <h3 class="card-title">
                            {{ $call->toString() }}
                        </h3>
                        <div class="card-text">
                            <p>
                                @include('partials.projectcall_dates', ['projectcall' => $call])
                            </p>
                        </div>
                        <a href="{{ route('projectcall.show',$call->id)}}" class="btn btn-primary d-inline-block my-1">
                            @svg('solid/search', 'icon-fw') {{ __('actions.projectcall.show') }}
                        </a>
                        <br />
                        @forelse ($call->applications as $application)
                            @break(!$loop->first)
                            @if(!empty($application->submitted_at))
                                <a href="{{ route('application.show',$call->applications[0]->id)}}" class="btn btn-secondary d-inline-block my-1">
                                    @svg('solid/search', 'icon-fw') {{ __('actions.application.show') }}
                                </a>
                            @elseif($call->canApply())
                                <a href="{{ route('application.edit',$call->applications[0]->id)}}" class="btn btn-warning d-inline-block my-1">
                                    @svg('solid/edit', 'icon-fw') {{ __('actions.application.edit') }}
                                </a>
                            @elseif($type == 'unsubmitted' && $application->devalidation_message !== null)
                                <a href="{{ route('application.edit',$call->applications[0]->id)}}" class="btn btn-danger d-inline-block my-1">
                                    @svg('solid/edit', 'icon-fw') {{ __('actions.application.correct') }}
                                </a>
                                <p class="text-justify">
                                    {{ __('fields.application.devalidated_1') }}
                                    <span class="font-weight-bold">
                                        "{{ $application->devalidation_message }}"
                                    </span>
                                    <br/>
                                    {{ __('fields.application.devalidated_2') }}
                                </p>
                            @endif
                        @empty
                            @if($call->canApply())
                                <a href="{{ route('projectcall.apply',$call->id)}}" class="btn btn-success d-inline-block my-1">
                                    @svg('solid/plus-square', 'icon-fw') {{ __('actions.projectcall.apply') }}
                                </a>
                            @endif
                        @endforelse
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
    @if(!$loop->last)
        <hr/>
    @endif
@endforeach