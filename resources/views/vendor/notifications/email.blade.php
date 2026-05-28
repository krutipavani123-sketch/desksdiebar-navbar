<x-mail::message>

# Reset Your Password

Click the button below to reset your password:

@if(isset($actionText))
<x-mail::button :url="$actionUrl">
Reset Password
</x-mail::button>
@endif

This link will expire in 60 minutes.  
If you did not request a password reset, ignore this email.

Thanks,<br>
{{ config('app.name') }}

@if(isset($actionText))
---

If the button doesn’t work, copy and paste this URL into your browser:  
{{ $displayableActionUrl }}
@endif

</x-mail::message>




{{-- <x-mail::message>

<div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">

# 🔒 Reset Your Password

Hello,

You requested a password reset. Click the button below to set a new password:



@if(isset($actionText))
<x-mail::button :url="$actionUrl" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg shadow-md">
Login
</x-mail::button>
@endif



@if(isset($actionText))
<x-mail::button :url="$actionUrl" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg shadow-md">
Reset Password
</x-mail::button>
@endif

<div class="text-gray-600 mt-4 text-sm">
This link will expire in 60 minutes. If you did not request a password reset, you can safely ignore this email.
</div>

<div class="mt-6 text-gray-500 text-sm">
Thanks,<br>
<strong>{{ config('app.name') }}</strong>
</div>

@if(isset($actionText))
<hr class="my-4 border-gray-200">
<div class="text-gray-400 text-xs">
If the button doesn’t work, copy and paste this URL into your browser:<br>
<a href="{{ $displayableActionUrl }}" class="text-indigo-600 hover:underline break-all">{{ $displayableActionUrl }}</a>
</div>
@endif

</div>

</x-mail::message> --}}