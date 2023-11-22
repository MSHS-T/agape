<x-guest-layout>
    <div
        class="min-h-screen flex flex-col justify-center items-center pt-6 pb-24 px-4 sm:px-0 bg-gray-100 dark:bg-gray-900">
        <div>
            <x-authentication-card-logo />
        </div>

        <h2 class="mt-6 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900 dark:text-white">
            {{ __('pages.legal') }}
        </h2>

        <div
            class="w-full sm:max-w-[50%] mt-6 px-6 py-12 shadow sm:rounded-lg sm:px-12 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 overflow-hidden prose prose-headings:text-gray-900 prose-headings:dark:text-white prose-a:text-gray-900 prose-a:dark:text-white prose-strong:text-gray-900 prose-strong:dark:text-white">
            {!! \Illuminate\Support\Str::of(file_get_contents(storage_path('app/legal.md')))->replace('{APP_URL}', env('APP_URL'))->replace('{APP_NAME}', env('APP_NAME'))->markdown([
                    'renderer' => [
                        'inner_separator' => '<br/>',
                        'soft_break' => '<br/>',
                    ],
                ]) !!}
        </div>
    </div>

</x-guest-layout>
