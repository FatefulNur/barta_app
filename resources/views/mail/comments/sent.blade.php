<x-mail::message>
# Hey! {{ $user }}

{{ $message }} **{{ $comment->body }}**

<x-mail::button :url="$url">
    View Post Comments
</x-mail::button>

Take Care,<br>
From {{ config('app.name') }}

<x-mail::panel>
If view post comment link not working then just [click here]({{ $url }}).
</x-mail::panel>
</x-mail::message>
