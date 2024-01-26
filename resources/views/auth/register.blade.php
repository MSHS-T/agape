<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-slot name="title">
            {!! __('pages.register.title') !!}
        </x-slot>


        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            @if (request()->has('invitation'))
                <x-input id="invitation" class="block mt-1 w-full" type="hidden" name="invitation" :value="request()->get('invitation')" />
            @endif

            <div>
                <x-label for="first_name" value="{{ __('attributes.first_name') }}" />
                <x-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')"
                    required autofocus autocomplete="first_name" />
            </div>

            <div class="mt-4">
                <x-label for="last_name" value="{{ __('attributes.last_name') }}" />
                <x-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')"
                    required autofocus autocomplete="last_name" />
            </div>

            <div class="mt-4">
                <x-label for="email" value="{{ __('attributes.email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autocomplete="username" aria-describedby="email-description" />
                <p class="mt-2 text-xs italic text-gray-500" id="email-description">
                    {{ __('pages.register.email_help') }}</p>

            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('attributes.password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" aria-describedby="password-description" />
                <p class="mt-2 text-xs italic text-gray-500" id="password-description">
                    {{ __('pages.register.password_help') }}
                </p>
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('attributes.password_confirmation') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                    'terms_of_service' =>
                                        '<a target="_blank" href="' .
                                        route('terms.show') .
                                        '" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">' .
                                        __('Terms of Service') .
                                        '</a>',
                                    'privacy_policy' =>
                                        '<a target="_blank" href="' .
                                        route('policy.show') .
                                        '" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">' .
                                        __('Privacy Policy') .
                                        '</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="mt-4 flex items-center justify-center">
                {!! HCaptcha::display() !!}
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    href="{{ route('login') }}">
                    {{ __('pages.register.login') }}
                </a>

                <x-button type="submit" class="ml-4">
                    {{ __('pages.register.register') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
