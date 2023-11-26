@props(['projectCall'])

@php
    $id = 'projectcall-modal-' . md5($projectCall->id);

    $maxWidth = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
    ][$maxWidth ?? '2xl'];
@endphp

<div x-data="{ show: false }" class="">
    <div x-on:close.stop="show = false" x-on:keydown.escape.window="show = false" x-show="show" id="{{ $id }}"
        class="jetstream-modal fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50 flex justify-center items-center"
        style="display: none;">
        <div x-show="show" class="fixed inset-0 transform transition-all" x-on:click="show = false"
            x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
        </div>

        <div x-show="show"
            class="relative mb-6 bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all w-full sm:max-w-md lg:max-w-xl
xl:max-w-2xl sm:mx-auto p-2 sm:p-8 lg:p-16"
            x-trap.inert.noscroll="show" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            <button type="button" class="absolute top-2 right-2" x-on:click="show = false">
                <x-fas-times class="w-6 h-6 text-gray-900 dark:text-white" />
            </button>
            <h2 class="text-4xl font-bold tracking-tight text-gray-900 dark:text-white text-center">
                {{ __('pages.view_project_call.title') }}
            </h2>
            <h3 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white text-center my-4">
                {{ $projectCall->projectCallType->label_long }} - {{ $projectCall->year }}
            </h3>
            @if (filled($projectCall->title))
                <p class="my-2 text-lg font-semibold leading-7 text-gray-600 dark:text-gray-400 text-center">
                    {{ $projectCall->title }}
                </p>
            @endif
            <div class="my-2 text-gray-600 dark:text-gray-400 text-start prose">
                {!! $projectCall->description !!}
            </div>
        </div>

    </div>
    <button type="button" x-on:click="show = true"
        class="w-full rounded-md bg-zinc-600 px-3 py-2 flex items-center justify-center space-x-2 text-sm font-semibold text-white shadow-sm hover:bg-zinc-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-zinc-600">
        <x-fas-magnifying-glass class="w-5 h-5" />
        <span>
            {{ __('pages.dashboard.view_project_call') }}
        </span>
    </button>
</div>
