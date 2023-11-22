<x-filament-panels::page>
    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (count($openOffers) > 0)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="mx-auto max-w-7xl px-6 lg:px-8">
                        <div class="mx-auto max-w-4xl sm:text-center">
                            <h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl pt-8">
                                {{ __('pages.dashboard.candidate.past_calls') }}
                            </h2>
                            {{-- <p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-200">
                            {{ __('pages.dashboard.candidate.description') }}
                        </p> --}}
                        </div>
                        <div @class([
                            'my-8 gap-4',
                            'grid grid-cols-1 md:grid-cols-2' => count($openOffers) > 1,
                            'flex justify-center' => count($openOffers) <= 1,
                        ]) id="open-calls">
                            @forelse ($openOffers as $offer)
                                {{-- <x-filament.project-call-card-candidate :projectCall="$projectCall" /> --}}
                            @empty
                                <h3 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white text-center pt-8"
                                    id="no-open-calls">
                                    {{ __('pages.dashboard.candidate.no_openCalls') }}
                                </h3>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endif
            @if (count($pendingEvaluation) > 0)
                <div class="mt-4 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="mx-auto max-w-7xl px-6 lg:px-8">
                        <div class="mx-auto max-w-4xl sm:text-center">
                            <h2
                                class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl pt-8">
                                {{ __('pages.dashboard.candidate.past_calls') }}
                            </h2>
                            {{-- <p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-200">
                            {{ __('pages.dashboard.candidate.description') }}
                        </p> --}}
                        </div>
                        <div @class([
                            'my-8 gap-4',
                            'grid grid-cols-1 md:grid-cols-2' => count($pendingEvaluation) > 1,
                            'flex justify-center' => count($pendingEvaluation) <= 1,
                        ]) id="open-calls">
                            @forelse ($pendingEvaluation as $offer)
                                {{-- <x-filament.project-call-card-candidate :projectCall="$projectCall" /> --}}
                            @empty
                                <h3 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white text-center pt-8"
                                    id="no-open-calls">
                                    {{ __('pages.dashboard.candidate.no_openCalls') }}
                                </h3>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endif
            @if (count($doneEvaluation) > 0)
                <div class="mt-4 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="mx-auto max-w-7xl px-6 lg:px-8">
                        <div class="mx-auto max-w-4xl sm:text-center">
                            <h2
                                class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl pt-8">
                                {{ __('pages.dashboard.candidate.past_calls') }}
                            </h2>
                            {{-- <p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-200">
                            {{ __('pages.dashboard.candidate.description') }}
                        </p> --}}
                        </div>
                        <div @class([
                            'my-8 gap-4',
                            'grid grid-cols-1 md:grid-cols-2' => count($doneEvaluation) > 1,
                            'flex justify-center' => count($doneEvaluation) <= 1,
                        ]) id="open-calls">
                            @forelse ($doneEvaluation as $offer)
                                {{-- <x-filament.project-call-card-candidate :projectCall="$projectCall" /> --}}
                            @empty
                                <h3 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white text-center pt-8"
                                    id="no-open-calls">
                                    {{ __('pages.dashboard.candidate.no_openCalls') }}
                                </h3>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-filament-panels::page>
