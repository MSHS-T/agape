<x-filament-panels::page>
    <div class="w-full max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
            <div class="mx-auto max-w-7xl px-2 lg:px-8">
                <div class="mx-auto max-w-4xl sm:text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl pt-8">
                        {{ __('pages.dashboard.candidate.open_calls') }}
                    </h2>
                </div>
                <div @class([
                    'my-8 gap-4',
                    'grid grid-cols-1 md:grid-cols-2' => count($openCalls) > 1,
                    'flex justify-center' => count($openCalls) <= 1,
                ]) id="open-calls">
                    @forelse ($openCalls as $projectCall)
                        <x-filament.project-call-card-candidate :projectCall="$projectCall" />
                    @empty
                        <h3 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white text-center pt-8"
                            id="no-open-calls">
                            {{ __('pages.dashboard.candidate.no_open_calls') }}
                        </h3>
                    @endforelse
                </div>
            </div>
        </div>
        @if (count($pastCalls) > 0)
            <div class="mt-4 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="mx-auto max-w-7xl px-6 lg:px-8">
                    <div class="mx-auto max-w-4xl sm:text-center">
                        <h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl pt-8">
                            {{ __('pages.dashboard.candidate.past_calls') }}
                        </h2>
                    </div>
                    <div @class([
                        'my-8 gap-4',
                        'grid grid-cols-1 md:grid-cols-2' => count($pastCalls) > 1,
                        'flex justify-center' => count($pastCalls) <= 1,
                    ]) id="open-calls">
                        @forelse ($pastCalls as $projectCall)
                            <x-filament.project-call-card-candidate :projectCall="$projectCall" />
                        @empty
                            <h3 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white text-center pt-8"
                                id="no-open-calls">
                                {{ __('pages.dashboard.candidate.no_past_calls') }}
                            </h3>
                        @endforelse
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-filament-panels::page>
