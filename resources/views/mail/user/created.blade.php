<x-mail::message>
Hello {{ $user->name }},

Your account has beeing created successfully.

**Here is your login ** <br>
Email: {{ $user->email }} <br>
Password: {{ $password }}

Please login to the system and change your password.

<x-mail::button url="{{ route('login') }}">
Click here to login
</x-mail::button>
Thank you, <br>
{{ config('app.name') }}
</x-mail::message>
