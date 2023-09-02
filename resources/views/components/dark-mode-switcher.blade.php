<button type="button" x-data="dark_mode_switcher" x-on:click="toggle"
    {{ $attributes->merge(['class' => 'block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out']) }}>
    <template x-if="theme === 'dark'">
        <div class="w-full flex items-center justify-start">
            <x-fas-moon class="w-4 h-4 mr-2" />
            {{ __('misc.theme.dark') }}
        </div>
    </template>
    <template x-if="theme === 'light'">
        <div class="w-full flex items-center justify-start">
            <x-fas-sun class="w-4 h-4 mr-2" />
            {{ __('misc.theme.light') }}
        </div>
    </template>
    <template x-if="theme === 'system'">
        <div class="w-full flex items-center justify-start">
            <x-fas-desktop class="w-4 h-4 mr-2" />
            {{ __('misc.theme.system') }}
        </div>
    </template>
</button>
@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('dark_mode_switcher', () => ({
                theme: 'system',

                init() {
                    const themeStorage = localStorage.getItem('theme');
                    if (!themeStorage || themeStorage === 'system') {
                        // No setting made, use system preference
                        this.setTheme('system');
                    } else {
                        this.setTheme(themeStorage === 'dark' ? 'dark' : 'light');
                    }
                },
                toggle() {
                    if (this.theme === 'system') {
                        this.setTheme('light');
                    } else if (this.theme === 'light') {
                        this.setTheme('dark');
                    } else {
                        this.setTheme('system');
                    }
                },
                setTheme(t) {
                    let newTheme;
                    if (t === 'system') {
                        newTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ?
                            'dark' : 'light';
                    } else {
                        newTheme = t;
                    }
                    if (newTheme === 'dark') {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                    this.theme = t;
                    localStorage.setItem('theme', t);
                }
            }))
        })
    </script>
@endpush
