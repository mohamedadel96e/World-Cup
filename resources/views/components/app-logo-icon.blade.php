@props(['imageUrl' => null])

@php
    $imageUrl = is_string($imageUrl) && !empty($imageUrl)
        ? $imageUrl
        : asset('images/germany.svg');

@endphp

<img src="{{ $imageUrl }}" alt="App Logo">
