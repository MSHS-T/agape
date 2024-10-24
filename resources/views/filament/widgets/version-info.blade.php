<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex items-center space-x-4 rtl:space-x-reverse">
            <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-black flex justify-center items-center">
                <x-fas-info class="w-4 h-4" />
            </div>

            <div class="flex-1">
                <h2 class="grid flex-1 text-base font-semibold leading-6 text-gray-950 dark:text-white">
                    {{ __('misc.version') }}
                </h2>

                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $version }}
                </p>
            </div>

            <a href="https://github.com/MSHS-T/agape" target="_blank" rel="noopener noreferrer"
                class="fi-btn relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg fi-color-gray fi-btn-color-gray fi-size-md fi-btn-size-md gap-1.5 px-3 py-2 text-sm hidden sm:inline-grid shadow-sm bg-white text-gray-950 hover:bg-gray-50 dark:bg-white/5 dark:text-white dark:hover:bg-white/10 ring-1 ring-gray-950/10 dark:ring-white/20"
                title="Github">
                <x-fab-github class="fi-btn-icon h-5 w-5" />
                <!--[if ENDBLOCK]><![endif]-->
                <span class="fi-btn-label sr-only">
                    Voir sur Github
                </span>
            </a>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
