<div class="hidden md:block">
    <div class="relative ml-3">
        <div>
            @if (Route::has('login'))

                @auth

{{--                    <a--}}
{{--                        href="{{ url('/dashboard') }}"--}}
{{--                        class="rounded-md px-3 py-1 text-black transition hover:text-gray-500 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-gray-300 dark:focus-visible:ring-white"--}}
{{--                    >--}}
{{--                        Dashboard--}}
{{--                    </a>--}}
                @else
                    <a
                        href="{{ route('login') }}"
                        class="rounded-md px-3 py-1 text-black transition hover:text-gray-500 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-gray-300 dark:focus-visible:ring-white"
                    >
                        Log In
                    </a>

                    @if (Route::has('register'))
                        <a
                            href="{{ route('register') }}"
                            class="rounded-md px-3 py-1 text-black transition hover:text-gray-500 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-gray-300 dark:focus-visible:ring-white"
                        >
                            Register
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </div>
</div>
