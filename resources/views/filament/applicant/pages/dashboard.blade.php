<x-filament-panels::page>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="mx-auto max-w-7xl px-6 lg:px-8">
                    <div class="mx-auto max-w-4xl sm:text-center">
                        <h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl pt-8">
                            {{ __('pages.dashboard.candidate.subtitle') }}
                        </h2>
                        {{-- <p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-200">
                            {{ __('pages.dashboard.candidate.description') }}
                        </p> --}}
                    </div>
                    <div @class([
                        'my-8 gap-x-4 gap-y-8',
                        'grid grid-cols-1 md:grid-cols-2' => count($openCalls) > 1,
                        'flex justify-center' => count($openCalls) <= 1,
                    ]) id="open-calls">
                        @forelse ($openCalls as $projectCall)
                            <x-filament.project-call-card-candidate :projectCall="$projectCall" />
                        @empty
                            <h3 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white text-center pt-8"
                                id="no-open-calls">
                                {{ __('pages.dashboard.candidate.no_openCalls') }}
                            </h3>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
