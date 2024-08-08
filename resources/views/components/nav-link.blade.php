@props(['active'])

@php
    $classes = ($active ?? false)
                ? 'inline-flex items-center px-3 py-1 border-b-2 border-gray-800 border-transparent text-sm font-medium leading-5 text-gray-900 underline focus:outline-none transition duration-150 ease-in-out'
                : 'inline-flex items-center px-3 py-1 border-b-2 border-transparent text-sm font-medium leading-5 text-black hover:text-gray-800 focus:outline-none focus:text-gray-500 focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
