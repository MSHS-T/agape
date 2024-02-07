@extends('layouts.export')

@php($imageBasePath = $debug ? '' : public_path())

@section('head_content')
    @include('export._style')
@endsection

@section('body')
    <div id="agape-logo-wrapper">
        <img src="{{ $imageBasePath }}/{{ env('APP_LOGO') }}" alt="{{ config('app.name') }}" id="agape-logo">
    </div>
    <h3 class="text-center">
        {!! __('admin.evaluation.export_name') !!}
    </h3>
    <h3 class="text-center">
        {{ $projectCall->projectCallType->label_short }} - {{ $projectCall->year }}
    </h3>

    <section>
        {{-- Display application data in a table --}}
        <table class="reference-table">
            <tr>
                <th>{{ __('attributes.reference') }}</th>
                <td>
                    <a name="application-{{ $application->reference }}">
                        {{ $application->reference }}
                    </a>
                </td>
            </tr>
            <tr>
                <th>{{ __('admin.roles.applicant') }}</th>
                <td>{{ $application->creator->name }}</td>
            </tr>
            <tr>
                <th>{{ __('attributes.title') }}</th>
                <td>
                    {{ $application->title }}
                    @if (!empty($application->acronym))
                        ({{ $application->acronym }})
                    @endif
                </td>
            </tr>
            <tr>
                <th>{{ __('attributes.main_laboratory') }}</th>
                <td>{{ $application->laboratories->first()->name ?? '?' }}</td>
            </tr>
        </table>

        @foreach ($application->evaluations as $evaluation)
            <h4 class="text-center title-bordered">
                <a name="evaluation-{{ $evaluation->id }}">
                    {{ __('resources.evaluation') }} #{{ $loop->iteration }}
                </a>
                @if (!$anonymized)
                    : {{ $evaluation->evaluationOffer->expert->name }}
                @endif
            </h4>

            <div class="evaluation">
                @include('export._evaluation_display', [
                    'evaluation' => $evaluation,
                    'anonymized' => $anonymized,
                ])
            </div>
        @endforeach

        @if ($application->selection_comity_opinion !== null)
            <h4 class="text-center title-bordered">
                <a name="application-{{ $application->reference }}-comity">
                    {{ __('attributes.selection_comity_opinion') }}
                </a>
            </h4>
            <p class="evaluation">
                {{ $application->selection_comity_opinion }}
            </p>
        @endif
    </section>

    <script type="text/php">
    if (isset($pdf)) {
        $text = "{PAGE_NUM} / {PAGE_COUNT}";
        $size = 10;
        $font = $fontMetrics->getFont("Arial");
        $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
        $x = ($pdf->get_width() - $width);
        $y = $pdf->get_height() - 35;
        $pdf->page_text($x, $y, $text, $font, $size);
    }
</script>
@endsection
