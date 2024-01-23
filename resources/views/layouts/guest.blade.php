<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body>
    <div class="font-sans text-gray-900 dark:text-gray-100 antialiased relative bg-gray-100 dark:bg-gray-900 py-8">
        {{ $slot }}
        <div class="absolute top-2 right-2 w-fit flex flex-row sm:flex-col items-end">
            <x-dark-mode-switcher />
            <x-language-switcher />
        </div>
        <div class="absolute inset-x-0 bottom-0 flex flex-col items-center text-sm py-4">
            <div class="flex items-center justify-center space-x-4">
                <span>
                    &copy; {{ config('app.name') }} 2018-{{ date('Y') }}
                </span>
                <a href="{{ route('contact') }}">{{ __('pages.contact.title') }}</a>
                <a href="{{ route('legal') }}">{{ __('pages.legal') }}</a>
            </div>
        </div>
    </div>

    @include('cookie-consent::index')

    @livewireScripts
    @stack('scripts')
</body>

</html>
