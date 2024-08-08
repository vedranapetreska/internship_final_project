<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-gray-100">
<!-- Background Image -->
<div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('images/background.jpg') }}'); background-size: cover; background-position: center; opacity: 0.6;"></div>

<!-- Main Content -->
<div class="relative min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
    <div>
        <a href="/">
            <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
        </a>
    </div>

    <div class="relative w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-lg rounded-lg">
        <!-- Form Container with Background -->
        <div class="p-6 bg-white bg-opacity-90 rounded-lg shadow-md">
            {{ $slot }}
        </div>
    </div>
</div>
</body>
</html>
