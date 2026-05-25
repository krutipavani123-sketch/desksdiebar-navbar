<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>

<script src="https://cdn.tailwindcss.com"></script>

<style>
    body {
        background: linear-gradient(135deg, #eef2ff, #f8fafc);
    }
</style>
</head>

<body class="h-screen flex items-center justify-center">

<!-- CARD -->
<div class="w-full max-w-md bg-white/90 backdrop-blur-xl rounded-3xl shadow-2xl p-10 border border-gray-100">

    <!-- Badge -->
    <div class="mb-5">
        <span class="text-xs bg-indigo-100 text-indigo-600 px-3 py-1 rounded-full font-medium">
            Secure Login Portal
        </span>
    </div>

    <!-- Title -->
    <h2 class="text-3xl font-bold text-gray-800">Welcome back</h2>
    <p class="text-gray-500 mt-1">
        Sign in to your support desk account
    </p>

    <form class="mt-8 space-y-5" method="post" action="{{ url('login') }}">
        @csrf

        <!-- EMAIL -->
        <div>
            <label class="text-sm font-semibold text-gray-700">Email Address</label>
            <div class="relative mt-2">
                <span class="absolute left-3 top-3 text-gray-400">📧</span>
                <input type="email"
                       name="email"
                       placeholder="you@company.com"
                       class="w-full pl-10 pr-4 py-3 border rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
            </div>
        </div>

        <!-- PASSWORD -->
        <div>
            <label class="text-sm font-semibold text-gray-700">Password</label>
            <div class="relative mt-2">
                <span class="absolute left-3 top-3 text-gray-400">🔒</span>
                <input type="password"
                       name="password"
                       placeholder="Enter your password"
                       class="w-full pl-10 pr-4 py-3 border rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
            </div>
        </div>

        <!-- LOGIN BUTTON -->
        <button type="submit"
                class="w-full bg-gradient-to-r from-indigo-600 to-indigo-500 hover:from-indigo-700 hover:to-indigo-600 text-white py-3 rounded-xl font-semibold shadow-md transition">
            Login →
        </button>

        <!-- FORGOT PASSWORD (FIXED - no nested form) -->
        <div class="text-center text-sm mt-3">
            <a href="{{ url('/forgot-password') }}"
               class="text-indigo-600 font-medium hover:underline">
                Forgot Password?
            </a>
        </div>

        <!-- REGISTER -->
        <p class="text-center text-sm text-gray-500 mt-4">
            Don’t have an account?
            <a href="{{ url('register') }}" class="text-indigo-600 font-semibold hover:underline">
                Create account
            </a>
        </p>

    </form>

</div>

</body>
</html>