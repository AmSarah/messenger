<x-mail::message>
Hello {{ $user->name }},

@if ($user->blocked_at)
Your account has been supsended. You are not longer able login.
@else
Your account been activated. You can now normally use the system.
<x-mail::button url="{{ route('login') }}">
Click here to login
</x-mail::button>
@endif

Thank you, <br>
{{ config('app.name') }}
</x-mail::message>
