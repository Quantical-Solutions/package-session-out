<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div>
                <h2 class="text-white text-xl font-bold text-center uppercase">{{ __('Session has expired') }}</h2>
            </div>
            <input id="email" class="block mt-1 w-full" type="hidden" name="email" value="{{ $email }}" required />

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <span class="flex items-center">
                    <a href="{{ route('login') }}" id="not-you" class="text-sm text-gray-300 hover:text-gray-100">{{ __('You are not') }} {{ $name }} ?</a>
                </span>
            </div>

            <div class="flex items-center justify-end mt-4">

                <x-jet-button class="ml-4">
                    {{ __('Login again') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
