@props(['projectCall'])

@php
    $id = 'projectcall-' . md5($projectCall->id);
    $application = $projectCall->getApplication();
@endphp

<div class="projectcall-card-candidate max-w-2xl rounded-3xl ring-1 ring-gray-200 flex flex-col items-stretch p-2"
    id="{{ $id }}">
    <div class="flex-1 lg:px-8 py-4 flex flex-col items-stretch">
        <div class="flex-1 flex flex-col justify-center">
            <h3 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white text-center">
                {{ $projectCall->projectCallType->label_long }} - {{ $projectCall->year }}
            </h3>
            @if (filled($projectCall->title))
                <p class="mt-6 text-base leading-7 text-gray-600 dark:text-gray-400 text-center">
                    {{ $projectCall->title }}
                </p>
            @endif
        </div>
        <div class="flex items-center gap-x-4">
            <div class="h-px flex-auto bg-gray-100 dark:bg-gray-700"></div>
            <h4 class="flex-none text-sm font-semibold leading-6 text-indigo-600">
                {{ __('pages.dashboard.planning') }}
            </h4>
            <div class="h-px flex-auto bg-gray-100 dark:bg-gray-700"></div>
        </div>
        <div class="flex justify-center py-2">
            <ul role="list"
                class="grid grid-cols-3 auto-cols-min gap-2 text-xs sm:text-sm leading-6 text-gray-600 dark:text-gray-300 sm:gap-x-6 sm:gap-y-2 items-center">
                <span class="text-center text-indigo-600">
                    {{ __('resources.application') }}
                </span>
                <span class="text-center flex items-center">
                    <span>
                        {{ $projectCall->application_start_date->format(__('misc.date_format')) }}
                    </span>
                    <x-fas-arrow-right class="w-3 h-3 text-indigo-600 mx-auto ml-4" />
                </span>
                <span class="">
                    {{ $projectCall->application_end_date->format(__('misc.date_format')) }}
                </span>
                <span class="text-center text-indigo-600">
                    {{ __('resources.evaluation') }}
                </span>
                <span class="text-center flex items-center">
                    <span>
                        {{ $projectCall->evaluation_start_date->format(__('misc.date_format')) }}
                    </span>
                    <x-fas-arrow-right class="w-3 h-3 text-indigo-600 mx-auto ml-4" />
                </span>
                <span class="">
                    {{ $projectCall->evaluation_end_date->format(__('misc.date_format')) }}
                </span>
            </ul>
        </div>
    </div>
    <div
        class="px-4 py-4 w-full rounded-2xl bg-gray-50 dark:bg-gray-700 text-center ring-1 ring-inset ring-gray-900/5 flex flex-col justify-center items-stretch">
        {{-- @if (filled($application) && filled($application->devalidation_message))
            <div class="px-6 py-2 text-sm leading-5 text-red-600 flex flex-col items-stretch">
                <strong>{{ __('pages.apply.devalidated_title') }} :</strong>
                <span>
                    {!! $application->devalidation_message !!}
                </span>
            </div>
        @endif --}}
        <div
            class="flex flex-col md:flex-row items-stretch md:items-center justify-center space-y-2 md:space-y-0 md:space-x-4">
            @if ($projectCall->canApply())
                <x-filament.project-call-display-modal :projectCall="$projectCall">
                    <button type="button" x-on:click="show = true"
                        class="w-full rounded-md bg-zinc-600 px-3 py-2 flex items-center justify-center space-x-2 text-sm font-semibold text-white shadow-sm hover:bg-zinc-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-zinc-600">
                        <x-fas-magnifying-glass class="w-5 h-5" />
                        <span>
                            {{ __('pages.dashboard.view_project_call') }}
                        </span>
                    </button>
                </x-filament.project-call-display-modal>
                @if (blank($application))
                    <a href="{{ route('filament.applicant.pages.apply', ['projectCall' => $projectCall]) }}"
                        class="block rounded-md bg-blue-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                        {{ __('pages.dashboard.candidate.create_application') }}
                    </a>
                @elseif(blank($application->submitted_at))
                    @if (filled($application->devalidation_message))
                        <a href="{{ route('filament.applicant.pages.apply', ['projectCall' => $projectCall]) }}"
                            class="block rounded-md bg-orange-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-orange-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-orange-600">
                            {{ __('pages.dashboard.candidate.correct_application') }}
                        </a>
                    @else
                        <a href="{{ route('filament.applicant.pages.apply', ['projectCall' => $projectCall]) }}"
                            class="mt-10 block rounded-md bg-blue-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                            {{ __('pages.dashboard.candidate.edit_application') }}
                        </a>
                    @endif
                @endif
            @endif
            @if (filled($application) && filled($application->submitted_at))
                <a href="{{ route('filament.applicant.pages.apply', ['projectCall' => $projectCall]) }}"
                    class="block rounded-md bg-green-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                    {{ __('pages.dashboard.candidate.view_application') }}
                </a>
            @endif
        </div>
    </div>
</div>
