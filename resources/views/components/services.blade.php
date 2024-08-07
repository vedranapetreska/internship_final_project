<section class="relative min-h-screen flex items-center justify-center bg-gray-800">
    <!-- Background Image -->
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ $backgroundImage }}'); background-size: cover; background-position: center; opacity: 0.6;"></div>
    <!-- Content -->
    <div class="relative z-10 p-6 text-left max-w-lg">
        <p class="text-white text-2xl font-semibold leading-tight">
            {!! $slot !!}
        </p>
    </div>
</section>
