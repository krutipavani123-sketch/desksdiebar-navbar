<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-50 via-white to-blue-50 px-4">

        <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 border border-gray-100">

            <!-- Header -->
            <div class="text-center mb-6">
                <div class="mx-auto w-12 h-12 flex items-center justify-center rounded-full bg-indigo-100 text-indigo-600 mb-3">
                    🔒
                </div>

                <h2 class="text-2xl font-bold text-gray-800">
                    Forgot Password?
                </h2>

                <p class="text-sm text-gray-500 mt-2">
                    No worries, we’ll send you reset instructions
                </p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Description -->
            <div class="mb-6 text-sm text-gray-600 bg-gray-50 p-3 rounded-lg border">
                {{ __('Enter your email address and we will send you a password reset link.') }}
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email Address')" class="text-gray-700 font-medium" />

                    <x-text-input
                        id="email"
                        type="email"
                        name="email"
                        class="block mt-2 w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                        :value="old('email')"
                        required
                        autofocus
                        placeholder="you@example.com"
                    />

                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Button -->
                <div>
                    <x-primary-button class="w-full justify-center py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 transition">
                        📩 Send Reset Link
                    </x-primary-button>
                </div>
            </form>

            <!-- Footer -->
            <div class="text-center mt-6 text-sm text-gray-500">
                Remember your password?
                <a href="{{ url('login') }}" class="text-indigo-600 font-medium hover:underline">
                    Back to Login
                </a>
            </div>

        </div>

    </div>
</x-guest-layout>