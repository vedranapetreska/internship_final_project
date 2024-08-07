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

        /* Style for the navigation bar to be fixed at the top */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            background-color: #008566;
            padding: 8px 16px;
        }

        /* Ensure content starts below the navbar */
        .content {
            padding-top: 70px; /* Adjust based on the height of your navbar */
        }
    </style>
</head>
<body>
<!-- Fixed Navigation Bar -->
<nav class="bg-customGreen border-b border-gray-100 fixed top-0 w-full z-50">
    <div class="container mx-auto px-6 py-3 flex justify-between items-center">
        <div class="flex items-center">
            <!-- Logo -->
            <a href="/" class="flex items-center">
                <x-application-logo class="block h-9 w-auto fill-current text-gray-800"></x-application-logo>
            </a>
            <!-- Navigation Links -->
            <div class="flex space-x-4 ml-6">
                <x-nav-link href="#">
                    {{ __('About Us') }}
                </x-nav-link>
                <x-nav-link href="#">
                    {{ __('Contact') }}
                </x-nav-link>
            </div>
        </div>

        <div class="rounded-md px-3 py-1 text-black transition hover:text-gray-500 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-gray-300 dark:focus-visible:ring-white">
            <x-login-registration></x-login-registration>
        </div>
    </div>
</nav>
</body>
</html>
