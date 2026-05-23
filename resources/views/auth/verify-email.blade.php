<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex items-center justify-center bg-gray-100">

    <div class="w-full max-w-md bg-white rounded-3xl shadow-xl p-12 border border-gray-100">

        <!-- ICON -->
        <div class="flex justify-center mb-6">
            <div class="w-16 h-16 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-2xl font-bold">
                ✉️
            </div>
        </div>

        <!-- TITLE -->
        <h2 class="text-3xl font-bold text-center text-gray-800">
            Verify Your Email
        </h2>

        <p class="text-center text-gray-500 text-sm mt-2 leading-relaxed">
            We’ve sent a verification link to your email address. Please check your inbox and verify your account to continue.
        </p>

        <!-- SUCCESS MESSAGE -->
        @if (session('status') == 'verification-link-sent')
            <div class="mt-4 p-3 bg-green-50 text-green-700 text-sm rounded-lg text-center">
                A new verification link has been sent successfully.
            </div>
        @endif

        <!-- RESEND VERIFICATION EMAIL -->
        <form method="POST" action="{{ route('verification.send') }}" class="mt-6">
            @csrf
            <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-xl font-semibold shadow-md transition-all duration-200">
                Resend Verification Email
            </button>
        </form>

        <!-- LOGOUT -->
        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <button type="submit"
                class="w-full bg-red-500 hover:bg-red-600 text-white py-3 rounded-xl font-semibold shadow-md transition-all duration-200">
                Log Out
            </button>
        </form>

        <!-- FOOTER NOTE -->
        <p class="text-xs text-center text-gray-400 mt-6">
            Didn’t receive email? Check spam folder or resend.
        </p>

    </div>

</body>
</html>