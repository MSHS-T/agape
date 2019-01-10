<h2 class="mb-3 text-center">{{ __('actions.projectcall.listopen') }}</h2>
<div class="row justify-content-center">
    @foreach($projectcalls as $call)
    <div class="col-4">
        <div class="card text-center" style="min-height: 17rem;">
            <div class="card-body">
                <h3 class="card-title">
                    {{ __('vocabulary.calltype_short.'.$call->typeLabel) . ' - ' . $call->year }}
                </h3>
                <div class="card-text">
                    <h4>{{$call->title}}</h4>
                    <p>
                        <u>Candidatures :</u> {{
                        \Carbon\Carbon::parse($call->application_start_date)->format(__('locale.date_format')) }} -
                        {{ \Carbon\Carbon::parse($call->application_end_date)->format(__('locale.date_format')) }}<br />
                        <u>Évaluations :</u> {{
                        \Carbon\Carbon::parse($call->evaluation_start_date)->format(__('locale.date_format')) }} -
                        {{ \Carbon\Carbon::parse($call->evaluation_end_date)->format(__('locale.date_format')) }}
                    </p>
                </div>
                <a href="{{ route('projectcall.show',$call->id)}}" class="btn btn-primary d-inline-block my-1">
                    @svg('solid/search', 'icon-fw') {{ __('actions.projectcall.show') }}
                </a>
                <br />
                @php
                $today = \Carbon\Carbon::parse('today');
                $can_apply = $today >= $call->application_start_date;
                $can_evaluate = $today >= $call->evaluation_start_date;
                @endphp
                @if($can_apply)
                <a href="{{ route('projectcall.applications', ['projectcall' => $call->id]) }}" class="btn btn-info d-inline-block my-1">
                    @svg('solid/link', 'icon-fw') {{ __('actions.application.show_all', ['count' =>
                    count($call->applications)]) }}
                </a>
                @endif
                @if($can_evaluate)
                <a href="#" class="btn btn-success d-inline-block my-1">
                    @svg('solid/graduation-cap', 'icon-fw') {{ __('actions.evaluation.show_all', ['count' =>
                    0]) }}
                </a>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
