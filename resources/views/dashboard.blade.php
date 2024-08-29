<x-app-layout>
    <div class="min-h-screen bg-gray-100 flex flex-col">

        @include('layouts.navigation')

        <section class="relative bg-cover bg-center py-20" style="background-image: url('{{ asset('images/image3.jpg') }}');">
            <div class="absolute inset-0 bg-black bg-opacity-40"></div>
            <div class="relative z-10 flex items-center justify-center h-full">
                <section class="relative bg-cover bg-center h-64 md:h-80" style="background-image: url('{{ asset('images/image3.jpg') }}');">
                    <div class="absolute inset-0 bg-black bg-opacity-30"></div>
                    <div class="relative flex items-center justify-center h-full">
                        <div class="text-center text-white px-4 md:px-8 py-6">
                            <h1 class="text-3xl md:text-4xl font-bold mb-2 leading-tight">Welcome to Tennis Club Prilep</h1>
                            <h2 class="text-xl md:text-2xl font-semibold">{{ Auth::user()->name }}</h2>
                        </div>
                    </div>
                </section>
            </div>
        </section>

        <section class="py-12 bg-white">
            <div class="container mx-auto text-center">
                <h3 class="text-3xl font-semibold mb-8">Our Services</h3>
                <div class="flex flex-wrap justify-center">

                    <div class="w-full sm:w-1/2 lg:w-1/3 px-4 mb-8">
                        <div class="bg-gray-200 p-6 rounded-lg shadow-lg">
                            <h4 class="text-xl font-bold mb-8">Court Booking</h4>
                            <p>Reserve your favorite court easily online.</p>
                        </div>
                    </div>

                    <div class="w-full sm:w-1/2 lg:w-1/3 px-4 mb-8">
                        <div class="bg-gray-200 p-6 rounded-lg shadow-lg">
                            <h4 class="text-xl font-bold mb-4">Coffee Bar</h4>
                            <p>Relax and enjoy a variety of coffee while watching the game. Our coffee bar offers a cozy atmosphere for you.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <section class="bg-green-600 py-12 text-white">
            <div class="container mx-auto text-center">
                <h3 class="text-3xl font-semibold mb-4">Ready to Play?</h3>
                <p class="mb-8">Book your court today and enjoy a fantastic tennis experience at Tennis Club Prilep.</p>
                <a href="{{ route('reservation.index') }}" class="bg-white text-green-600 px-8 py-4 rounded-full shadow-lg hover:bg-gray-100 transition">Make a Reservation</a>
            </div>
        </section>

        <!-- Footer -->
        <x-footer class="mt-auto"></x-footer>
    </div>
</x-app-layout>
