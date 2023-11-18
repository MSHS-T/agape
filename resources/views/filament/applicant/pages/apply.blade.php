<x-filament-panels::page>
    <div class="px-4 py-5 bg-white dark:bg-gray-800 sm:p-6 shadow sm:rounded-md">
        <div class="grid grid-cols-1 gap-6">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 text-center">
                {{ $projectCall->projectCallType->label_long }} - {{ $projectCall->year }}
            </h3>
            @if (filled($projectCall->title))
                <p class="text-base leading-7 text-xl font-semibold text-gray-600 dark:text-gray-400 text-center">
                    {{ $projectCall->title }}
                </p>
            @endif
            <div class="flex items-center gap-x-4">
                <div class="h-px flex-auto bg-gray-100 dark:bg-gray-700"></div>
                <h4 class="flex-none text-sm font-semibold leading-6 text-indigo-600">
                    {{ __('pages.dashboard.planning') }}
                </h4>
                <div class="h-px flex-auto bg-gray-100 dark:bg-gray-700"></div>
            </div>
            <div class="flex justify-center">
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
    </div>

    <div class="hidden sm:block">
        <div class="pt-2">
            <div class="border-t border-gray-200 dark:border-gray-700"></div>
        </div>
    </div>


    <form wire:submit.prevent="submitApplication" class="mt-4">
        {{ $this->form }}

        <div
            class="w-full rounded-lg bg-white dark:bg-gray-800 text-center ring-1 ring-inset ring-gray-900/5 flex justify-center items-center mt-8 py-4 space-x-4">
            <a href="{{ route('filament.applicant.pages.dashboard') }}"
                class="flex items-center space-x-2 rounded-md bg-zinc-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-zinc-600">
                <x-fas-arrow-left class="h-4 w-4" />
                <span>
                    {{ __('pages.apply.back') }}
                </span>
            </a>
            <button type="button" wire:click="saveDraft"
                class="flex items-center space-x-2 rounded-md bg-blue-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                <x-fas-save class="h-4 w-4" />
                <span>
                    {{ __('pages.apply.save') }}
                </span>
            </button>
            <button type="submit"
                class="flex items-center space-x-2 rounded-md bg-green-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                <x-fas-paper-plane class="h-4 w-4" />
                <span>
                    {{ __('pages.apply.submit') }}
                </span>
            </button>
        </div>
    </form>
</x-filament-panels::page>
