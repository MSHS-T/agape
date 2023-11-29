<x-filament-panels::page>
    <div class="px-4 py-5 bg-white dark:bg-gray-800 sm:p-6 shadow sm:rounded-md flex flex-col items-stretch">
        <div class="flex-1 px-8 pt-4 flex flex-col xl:flex-row justify-between items-center">
            <div class="flex-1 flex flex-col justify-center items-start">
                <h3 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                    {{ $evaluationOffer->application->projectCall->projectCallType->label_long }} -
                    {{ $evaluationOffer->application->projectCall->year }}
                </h3>
            </div>
            <h4
                class="text-base leading-6 text-indigo-600 flex flex-col md:flex-row justify-center items-stretch md:items-center gap-x-4">
                <span class="text-center text-indigo-600 font-semibold">
                    {{ __('pages.dashboard.expert.evaluation_period') }}
                </span>
                <span class="text-center flex items-center justify-center gap-x-4">
                    <span>
                        {{ $evaluationOffer->application->projectCall->evaluation_start_date->format(__('misc.date_format')) }}
                    </span>
                    <span>
                        <x-fas-arrow-right class="w-3 h-3 text-indigo-600" />
                    </span>
                    <span class="">
                        {{ $evaluationOffer->application->projectCall->evaluation_end_date->format(__('misc.date_format')) }}
                    </span>
                </span>
            </h4>
        </div>
        @if (filled($evaluationOffer->application->projectCall->title))
            <p class="mt-1 text-base leading-7 text-gray-600 dark:text-gray-400 px-8">
                {{ $evaluationOffer->application->projectCall->title }}
            </p>
        @endif
        <hr class="mx-16 my-2" />
        <p class="mt-1 text-lg font-bold leading-7 text-gray-800 dark:text-gray-200 px-8">
            {{ __('pages.dashboard.expert.application_by', ['title' => $evaluationOffer->application->title, 'applicant' => $evaluationOffer->application->creator->name]) }}
        </p>
        <div class="mt-1 text-base leading-7 text-gray-600 dark:text-gray-400 px-8">
            {!! $evaluationOffer->application->short_description !!}
        </div>
    </div>

    <div class="hidden sm:block">
        <div class="pt-2">
            <div class="border-t border-gray-200 dark:border-gray-700"></div>
        </div>
    </div>

    @if (
        $evaluationOffer->application->projectCall->canEvaluate() &&
            blank($evaluation->submitted_at) &&
            filled($evaluation->devalidation_message))
        <div class="px-4 py-5 bg-red-300 dark:bg-red-900/50 sm:p-6 shadow sm:rounded-md">
            <div class="grid grid-cols-1 gap-6">
                <h4 class="leading-7 text-xl font-semibold text-gray-600 dark:text-gray-400">
                    {{ __('pages.apply.devalidated_title') }} :
                </h4>
                <div
                    class="mx-16 px-8 py-4 border-l-4 border-red-400 leading-7 text-lg !text-gray-600 !dark:text-gray-400">
                    {!! $evaluation->devalidation_message !!}
                </div>
                <p class="leading-5 text-base font-semibold italic text-gray-600 dark:text-gray-400">
                    {{ __('pages.apply.devalidated_help') }}
                </p>
            </div>
        </div>

        <div class="hidden sm:block">
            <div class="pt-2">
                <div class="border-t border-gray-200 dark:border-gray-700"></div>
            </div>
        </div>
    @endif

    @if ($evaluationOffer->application->projectCall->canApply() && filled($evaluation->submitted_at))
        <div class="px-4 py-5 bg-green-300 dark:bg-green-900/50 sm:p-6 shadow sm:rounded-md">
            <div class="grid grid-cols-1 gap-6">
                <h4 class="leading-7 text-xl font-semibold text-gray-600 dark:text-gray-400">
                    {{ __('pages.apply.submitted') }}
                </h4>
            </div>
        </div>

        <div class="hidden sm:block">
            <div class="pt-2">
                <div class="border-t border-gray-200 dark:border-gray-700"></div>
            </div>
        </div>
    @endif

    <div class="mt-4 pb-24 sm:pb-12 space-y-4" x-data="{ activeTab: 'evaluation' }">
        <x-filament::tabs label="Content tabs">
            <x-filament::tabs.item alpine-active="activeTab === 'projectcall'" x-on:click="activeTab = 'projectcall'">
                {{ __('resources.project_call') }}
            </x-filament::tabs.item>
            <x-filament::tabs.item alpine-active="activeTab === 'application'" x-on:click="activeTab = 'application'">
                {{ __('resources.application') }}
            </x-filament::tabs.item>
            <x-filament::tabs.item alpine-active="activeTab === 'evaluation'" x-on:click="activeTab = 'evaluation'">
                {{ __('resources.evaluation') }}
            </x-filament::tabs.item>
        </x-filament::tabs>
        <div x-cloak x-show="activeTab === 'application'">
            {{ $this->applicationForm }}
        </div>
        <div x-cloak x-show="activeTab === 'evaluation'">
            {{ $this->form }}
        </div>
        <div x-cloak x-show="activeTab === 'projectcall'">
            <div
                class="flex flex-col items-center max-w-full gap-x-1 overflow-x-auto mx-auto rounded-xl bg-white p-2 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <h3 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white text-center my-4">
                    {{ $this->evaluationOffer->application->projectCall->projectCallType->label_long }} -
                    {{ $this->evaluationOffer->application->projectCall->year }}
                </h3>
                @if (filled($this->evaluationOffer->application->projectCall->title))
                    <p class="my-2 text-lg font-semibold leading-7 text-gray-600 dark:text-gray-400 text-center">
                        {{ $this->evaluationOffer->application->projectCall->title }}
                    </p>
                @endif
                <div class="my-2 text-gray-600 dark:text-gray-400 text-start prose">
                    {!! $this->evaluationOffer->application->projectCall->description !!}
                </div>

            </div>
        </div>
    </div>
</x-filament-panels::page>
