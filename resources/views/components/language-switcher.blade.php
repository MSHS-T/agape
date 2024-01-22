@php
    $flags = config('agape.flags');
    $locale = app()->getLocale();
    $allLocales = config('agape.languages');
@endphp

<button type="button" x-data="language_switcher" x-on:click="next"
    {{ $attributes->merge(['class' => 'block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out']) }}>
    <div class="w-full flex items-center justify-start">
        <x-dynamic-component :component="'flag-1x1-' . ($flags[$locale] ?? $locale)"
            class="flex-shrink-0 w-4 h-4 mr-2 group-hover:text-white group-focus:text-white text-primary-500"
            style="border-radius: 0.25rem" />
        {{ str(locale_get_display_name($locale, app()->getLocale()))->title()->toString() }}
    </div>
</button>
@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('language_switcher', () => ({
                locale: '{{ $locale }}',
                allLocales: @json($allLocales),

                next() {
                    const currentIndex = this.allLocales.indexOf(this.locale);
                    const nextLocale = this.allLocales[(currentIndex + 1) % this.allLocales.length];
                    window.location = '/locale/' + nextLocale;
                },

            }))
        })
    </script>
@endpush
