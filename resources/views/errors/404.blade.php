<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="flex flex-col items-center space-y-4">
            <h2 class="font-semibold text-center">
                {{ __('misc.errors.404') }}
            </h2>
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                href="{{ route('home') }}">
                {{ __('misc.errors.back') }}
            </a>
        </div>
    </x-authentication-card>
</x-guest-layout>
