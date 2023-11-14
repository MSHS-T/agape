@props(['projectCall'])

@php
    $application = $projectCall->getApplication();
@endphp

<div class="mx-auto my-8 max-w-2xl rounded-3xl ring-1 ring-gray-200 lg:mx-0 lg:flex lg:max-w-none lg:items-stretch">
    <div class="p-8 sm:p-10 lg:flex-auto">
        <h3 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white text-center">
            {{ $projectCall->projectCallType->label_long }} - {{ $projectCall->year }}
        </h3>
        @if (filled($projectCall->title))
            <p class="mt-6 text-base leading-7 text-gray-600 dark:text-gray-400 text-center">
                {{ $projectCall->title }}
            </p>
        @endif
        <div class="mt-6 mx-16 flex items-center gap-x-4">
            <h4 class="flex-none text-sm font-semibold leading-6 text-indigo-600">
                {{ __('pages.dashboard.planning') }}
            </h4>
            <div class="h-px flex-auto bg-gray-100 dark:bg-gray-700"></div>
        </div>
        <ul role="list"
            class="mt-6 mx-32 grid grid-cols-4 gap-4 text-sm leading-6 text-gray-600 dark:text-gray-300 sm:gap-x-6 sm:gap-y-4 items-center">
            <span class="text-indigo-600">
                {{ __('resources.application') }}
            </span>
            <span class="">
                {{ $projectCall->application_start_date->format(__('misc.date_format')) }}
            </span>
            <x-fas-arrow-right class="w-3 h-3 text-indigo-600 mx-auto" />
            <span class="">
                {{ $projectCall->application_end_date->format(__('misc.date_format')) }}
            </span>
            <span class="text-indigo-600">
                {{ __('resources.evaluation') }}
            </span>
            <span>
                {{ $projectCall->evaluation_start_date->format(__('misc.date_format')) }}
            </span>
            <x-fas-arrow-right class="w-3 h-3 text-indigo-600 mx-auto" />
            <span>
                {{ $projectCall->evaluation_end_date->format(__('misc.date_format')) }}
            </span>
        </ul>
    </div>
    <div class="-mt-2 p-2 lg:mt-0 lg:w-full lg:max-w-md lg:flex-shrink-0">
        <div
            class="h-full rounded-2xl bg-gray-50 dark:bg-gray-700 py-5 text-center ring-1 ring-inset ring-gray-900/5 lg:flex lg:flex-col lg:justify-center lg:py-8">
            <div class="mx-auto max-w-xs px-8">
                @if ($projectCall->canApply())
                    @if (blank($application))
                        <a href="#"
                            class="block w-full rounded-md bg-blue-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                            Create application
                        </a>
                    @elseif(blank($application->submitted_at))
                        @if (filled($application->devalidation_message))
                            <p class="mt-6 text-xs leading-5 text-gray-600">
                                {{ $application->devalidation_message }}
                            </p>
                            <a href="#"
                                class="mt-10 block w-full rounded-md bg-orange-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-orange-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-orange-600">
                                Fix application
                            </a>
                        @else
                            <a href="#"
                                class="mt-10 block w-full rounded-md bg-blue-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                                Edit application
                            </a>
                        @endif
                    @endif
                @endif
                @if (filled($application))
                    <a href="#"
                        class="block w-full rounded-md bg-green-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                        View application
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
