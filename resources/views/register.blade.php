<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-screen bg-gray-100 flex items-center justify-center">

<!-- FIXED CONTAINER -->
<div class="w-full max-w-md bg-white rounded-3xl shadow-xl p-12">

    <div class="mb-6">
        <span class="text-xs bg-indigo-100 text-indigo-600 px-3 py-1 rounded-full">
            Secure Login Portal
        </span>
    </div>

    <h2 class="text-3xl font-bold">Welcome back</h2>
    <p class="text-gray-500 mt-1">Sign in to your support desk account to continue.</p>

    <form class="mt-8 space-y-5" method="post" action="{{ url('register') }}">
        @csrf

        <!-- NAME -->
        <div>
            <label class="text-sm font-medium">Name</label>
            <input type="text"
                   placeholder="xyz"
                   name="name"
                   class="w-full mt-2 px-4 py-3 border rounded-xl">
        </div>

        <!-- EMAIL -->
        <div>
            <label class="text-sm font-medium">Email Address</label>
            <input type="email"
                   placeholder="you@company.com"
                   name="email"
                   class="w-full mt-2 px-4 py-3 border rounded-xl">
        </div>

        <!-- PASSWORD -->
        <div>
            <label class="text-sm font-medium">Password</label>
            <input type="password"
                   placeholder="Enter your password"
                   name="password"
                   class="w-full mt-2 px-4 py-3 border rounded-xl">
        </div>

        <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-xl font-semibold">
            Sign In →
        </button>

        

    </form>

</div>

</body>
</html> 