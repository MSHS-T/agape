@props(['projectCall'])

@php
    $id = 'projectcall-' . md5($projectCall->id);
    $application = $projectCall->getApplication();
@endphp

<div class="projectcall-card-candidate max-w-2xl rounded-3xl ring-1 ring-gray-200 flex flex-col items-stretch p-2"
    id="{{ $id }}">
    <div class="flex-1 p-8 flex flex-col items-stretch">
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
        <div class="mt-6 flex items-center gap-x-4">
            <div class="h-px flex-auto bg-gray-100 dark:bg-gray-700"></div>
            <h4 class="flex-none text-sm font-semibold leading-6 text-indigo-600">
                {{ __('pages.dashboard.planning') }}
            </h4>
            <div class="h-px flex-auto bg-gray-100 dark:bg-gray-700"></div>
        </div>
        <div class="flex justify-center py-4">
            <ul role="list"
                class="grid grid-cols-3 auto-cols-min gap-4 text-sm leading-6 text-gray-600 dark:text-gray-300 sm:gap-x-6 sm:gap-y-4 items-center">
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
        class="h-24 w-full rounded-2xl bg-gray-50 dark:bg-gray-700 text-center ring-1 ring-inset ring-gray-900/5 flex justify-center items-center space-x-4">
        @if ($projectCall->canApply())
            <x-filament.project-call-display-modal :projectCall="$projectCall" />
            @if (blank($application))
                <a href="{{ route('projectcall.apply', ['projectCall' => $projectCall]) }}"
                    class="block rounded-md bg-blue-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                    {{ __('pages.dashboard.candidate.create_application') }}
                </a>
            @elseif(blank($application->submitted_at))
                @if (filled($application->devalidation_message))
                    <p class="mt-6 text-xs leading-5 text-gray-600">
                        {{ $application->devalidation_message }}
                    </p>
                    <a href="{{ route('projectcall.apply', ['projectCall' => $projectCall]) }}"
                        class="mt-10 block rounded-md bg-orange-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-orange-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-orange-600">
                        {{ __('pages.dashboard.candidate.correct_application') }}
                    </a>
                @else
                    <a href="{{ route('projectcall.apply', ['projectCall' => $projectCall]) }}"
                        class="mt-10 block rounded-md bg-blue-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                        {{ __('pages.dashboard.candidate.edit_application') }}
                    </a>
                @endif
            @endif
        @endif
        @if (filled($application))
            <a href="#"
                class="block rounded-md bg-green-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                {{ __('pages.dashboard.candidate.view_application') }}
            </a>
        @endif
    </div>
</div>
