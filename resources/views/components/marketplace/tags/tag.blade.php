@props([
    // You can pass 'primary', 'secondary', 'success', 'danger', or 'warning'
    'color' => 'secondary',
    'size' => 'md', // 'sm', 'md', 'lg'
    'link' => null,
])

@php
    $colorClasses = [
        'primary' => 'bg-orange-500 text-white',
        'secondary' => 'bg-zinc-200 text-zinc-800 dark:bg-zinc-700 dark:text-zinc-200 hover:bg-zinc-300 dark:hover:bg-zinc-600',
        'success' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 hover:bg-green-200 dark:hover:bg-green-800',
        'danger' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300 hover:bg-red-200 dark:hover:bg-red-800',
        'warning' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300 hover:bg-yellow-200 dark:hover:bg-yellow-800',
        'link' => 'bg-transparent text-zinc-600 dark:text-zinc-400 hover:text-orange-500 dark:hover:text-orange-400'
    ];

    $sizeClasses = [
        'sm' => 'px-2.5 py-0.5 text-xs',
        'md' => 'px-3 py-1 text-sm',
        'lg' => 'px-4 py-1.5 text-base',
    ];

    // Default to 'secondary' if an invalid color is passed
    $selectedColor = $colorClasses[$color] ?? $colorClasses['secondary'];
    $selectedSize = $sizeClasses[$size] ?? $sizeClasses['md'];
@endphp

@if(isset($link))
    <a href="{{ $link }}" {{ $attributes->merge(['class' => 'inline-flex items-center justify-center text-center rounded-full font-semibold ' . $selectedColor . ' ' . $selectedSize . ' transition-colors duration-300']) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['class' => 'inline-flex items-center justify-center text-center rounded-full font-semibold ' . $selectedColor . ' ' . $selectedSize . ' transition-colors duration-300']) }}>
        {{ $slot }}
    </button>
@endif
