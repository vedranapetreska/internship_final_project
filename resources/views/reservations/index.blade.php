<x-app-layout>
    <!-- Page Content -->
    <div class="min-h-screen bg-gray-100">
        <!-- Standard Navigation -->
        @include('layouts.navigation')

        <section class="relative min-h-screen flex flex-col items-center justify-center bg-gray-400 p-6">

            @include('reservations.reservations-table',['slot1'=>'/reservations/index'])

            <!-- Make Reservation Button -->
            <div class="mt-4">
                <a href="{{ route('reservation.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Make a Reservation
                </a>
            </div>
        </section>

        <!-- Footer -->
        <x-footer></x-footer>
    </div>
</x-app-layout>
