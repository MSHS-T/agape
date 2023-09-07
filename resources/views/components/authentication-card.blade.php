<div
    class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0 px-4 sm:px-0 bg-gray-100 dark:bg-gray-900">
    <div>
        {{ $logo }}
    </div>

    @if (isset($title))
        <h2 class="mt-6 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900 dark:text-white">
            {{ $title }}
        </h2>
    @endif

    <div
        class="w-full sm:max-w-md mt-6 px-6 py-12 shadow sm:rounded-lg sm:px-12 bg-white dark:bg-gray-800 overflow-hidden">
        {{ $slot }}
    </div>
</div>
