@props([
    'imageUrl' => null,
    'additionalClasses' => ''
])

@php
    $imageUrl = is_string($imageUrl) && !empty($imageUrl)
        ? $imageUrl
        : asset('images/appLogo.png');


@endphp

<img src="{{ $imageUrl }}" alt="App Logo" class="rounded-lg {{ $additionalClasses }}">
