<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <style>
        /* Ensure body margin is zero to prevent default spacing issues */
        body {
            margin: 0;
            font-family: sans-serif;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
@include('layouts.navigation')

<x-services backgroundImage="{{ asset('images/image1.jpg') }}">
    <span class="block">Welcome to</span>
    <span class="block">Tennis Club Prilep</span>
</x-services>

<x-footer></x-footer>

</body>
</html>
