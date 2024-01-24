<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-slot name="title">
            {!! __('pages.login.title') !!}
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('attributes.email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                    autofocus autocomplete="username" />
            </div>

            <div class="mt-6">
                <x-label for="password" value="{{ __('attributes.password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="current-password" />
            </div>

            <div class="mt-6 flex items-center justify-between">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span
                        class="ml-3 text-sm font-semibold text-gray-900 dark:text-gray-100">{{ __('pages.login.remember_me') }}</span>
                </label>
                @if (Route::has('password.request'))
                    <div class="text-sm leading-6">
                        <a href="{{ route('password.request') }}"
                            class="font-semibold text-indigo-600 hover:text-indigo-500">
                            {{ __('pages.forgot_password.title') }}
                        </a>
                    </div>
                @endif
            </div>

            <div class="mt-6 flex items-center justify-center">
                <span class="dark:hidden">
                    {!! HCaptcha::display() !!}
                </span>
                <span class="hidden dark:block">
                    {!! HCaptcha::display(['data-theme' => 'dark']) !!}
                </span>
            </div>

            <div class="mt-6 flex justify-center items-center">
                <x-button type="submit" color="primary" class="w-full">
                    {{ __('pages.login.login') }}
                </x-button>
            </div>
        </form>

        @if (Route::has('register'))
            <div class="pt-6">
                <x-separator>{{ __('or') }}</x-separator>
                <div class="mt-6 flex justify-center">
                    <x-button tag="a" href="{{ route('register') }}" color="info" class="w-full">
                        {{ __('pages.login.register') }}
                    </x-button>
                </div>
            </div>
        @endif
    </x-authentication-card>
</x-guest-layout>
