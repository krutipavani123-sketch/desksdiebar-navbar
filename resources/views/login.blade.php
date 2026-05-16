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

    <form class="mt-8 space-y-5" method="post" action="{{ url('login') }}">
        @csrf

        

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

            {{-- <input type="submit" name="submit" value="submit"> --}}

        <button type="submit"  class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-xl font-semibold">
            Login→
        </button>

       <div class="text-center text-sm text-gray-500 mt-4">
    <form action="{{ route('loginmail') }}" method="POST" class="inline">
        @csrf
        
        <button type="submit" class="text-indigo-600 font-medium hover:underline">
            Forgot Password? Reset Password
        </button>
    </form>
</div>


          <p class="text-center text-sm text-gray-500 mt-4">
        Don’t have an account?
        <a href="{{ url('register') }}" class="text-indigo-600 font-medium">Create an account</a>
    </p>

    </form>

</div>

</body>
</html> 


{{-- <div class="text-center text-sm text-gray-500 mt-4">
    <form action="{{ route('loginmail') }}" method="POST">
        @csrf

        <input type="hidden" name="email" id="forgot-email">

        <button type="submit"
            onclick="document.getElementById('forgot-email').value =
            document.querySelector('input[name=email]').value"
            class="text-indigo-600 font-medium hover:underline">
            Forgot Password? Reset Password
        </button>
    </form>
</div> --}}