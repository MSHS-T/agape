<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('pages.dashboard.title') }}
        </h2>
    </x-slot>

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
                    @foreach ($open_calls as $projectCall)
                        <x-project-call-card-candidate :projectCall="$projectCall" />
                    @endforeach
                </div>
            </div>
</x-app-layout>
