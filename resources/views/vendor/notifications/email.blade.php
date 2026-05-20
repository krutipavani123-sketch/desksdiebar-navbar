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