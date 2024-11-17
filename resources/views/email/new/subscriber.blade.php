<x-mail::message>
# Introduction

Thank you for subscribe

<x-mail::button :url="route('frontend.index')">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
