<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">

        <div class="w-full max-w-md bg-white rounded-2xl shadow-xl border border-gray-100 p-8">

            <!-- Header -->
            <div class="text-center mb-6">

                <div class="mx-auto w-12 h-12 flex items-center justify-center rounded-full 
                            bg-indigo-100 text-indigo-600 mb-3">
                    🔑
                </div>

                <h2 class="text-2xl font-bold text-gray-800">
                    Reset Password
                </h2>

                <p class="text-sm text-gray-500 mt-2">
                    Create a new secure password for your account
                </p>
            </div>

            <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
                @csrf

                <!-- Token -->
                <input type="hidden" name="token" value="{{ $token }}">

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email Address')" />

                    <x-text-input
                        id="email"
                        type="email"
                        name="email"
                        class="block mt-2 w-full rounded-xl border-gray-300 
                               focus:border-indigo-500 focus:ring-indigo-500"
                        :value="old('email', $email)"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="you@example.com"
                    />

                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('New Password')" />

                    <x-text-input
                        id="password"
                        type="password"
                        name="password"
                        class="block mt-2 w-full rounded-xl border-gray-300 
                               focus:border-indigo-500 focus:ring-indigo-500"
                        required
                        autocomplete="new-password"
                        placeholder="Enter new password"
                    />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                    <x-text-input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        class="block mt-2 w-full rounded-xl border-gray-300 
                               focus:border-indigo-500 focus:ring-indigo-500"
                        required
                        autocomplete="new-password"
                        placeholder="Confirm new password"
                    />

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Button -->
                <div class="pt-2">
                    <x-primary-button
                        class="w-full justify-center py-3 rounded-xl 
                               bg-indigo-600 hover:bg-indigo-700 transition">
                        🔒 Reset Password
                    </x-primary-button>
                </div>

            </form>

        </div>

    </div>
</x-guest-layout>