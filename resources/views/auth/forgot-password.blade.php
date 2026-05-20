<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-screen bg-gray-100 flex items-center justify-center">

<!-- FIXED CONTAINER -->
<div class="w-full max-w-md bg-white rounded-3xl shadow-xl p-12">

    <div class="mb-6">
        <span class="text-xs bg-indigo-100 text-indigo-600 px-3 py-1 rounded-full">
            Secure Account
        </span>
    </div>

    <h2 class="text-3xl font-bold">Forgot Password</h2>
    <p class="text-gray-500 mt-1">
        Enter your email to receive reset link
    </p>

    <form class="mt-8 space-y-5" method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- EMAIL -->
        <div>
            <label class="text-sm font-medium">Email Address</label>
            <input type="email"
                   name="email"
                   value="{{ old('email') }}"
                   placeholder="you@company.com"
                   class="w-full mt-2 px-4 py-3 border rounded-xl">
        </div>

        <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-xl font-semibold">
            Send Reset Link →
        </button>

        <p class="text-center text-sm text-gray-500 mt-4">
            Remember password?
            <a href="{{ url('login') }}" class="text-indigo-600 font-medium">Login</a>
        </p>

    </form>

</div>

</body>
</html>