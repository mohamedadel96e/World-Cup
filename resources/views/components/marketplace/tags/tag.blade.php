@props([
    // You can pass 'primary', 'secondary', 'success', 'danger', or 'warning'
    'color' => 'secondary',
    'size' => 'md', // 'sm', 'md', 'lg'
    'link' => null,
])

@php
    $colorClasses = [
        'primary' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300 hover:bg-blue-200 dark:hover:bg-blue-800',
        'secondary' => 'bg-zinc-100 text-zinc-800 dark:bg-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-600',
        'success' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 hover:bg-green-200 dark:hover:bg-green-800',
        'danger' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300 hover:bg-red-200 dark:hover:bg-red-800',
        'warning' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300 hover:bg-yellow-200 dark:hover:bg-yellow-800',
    ];

    // Default to 'secondary' if an invalid color is passed
    $selectedClasses = $colorClasses[$color] ?? $colorClasses['secondary'];
@endphp

<a href="{{ $link }}" {{ $attributes->merge(['class' => 'inline-flex items-center justify-center text-center  rounded-full px-2.5 py-0.5 text-' . $size . ' font-semibold ' . $selectedClasses]) }}>
    {{ $slot }}
</a>
