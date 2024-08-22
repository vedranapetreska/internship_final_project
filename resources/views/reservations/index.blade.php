<x-app-layout>
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <section class="relative min-h-screen flex flex-col items-center justify-center bg-gray-400 p-6" style="margin-top: 2rem">
            @include('reservations.reservations-table', ['slot1' => route('reservation.index')])
            <div class="mt-4">
{{--                <a href="{{route('reservation.create')}}" class="inline-flex items-center px-2 py-1 border border-transparent text-small font-medium rounded-lg shadow-sm text-black bg-indigo-300 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">--}}
{{--                    Make a Reservation--}}
{{--                </a>--}}
                <a href="{{ route('reservation.show') }}" class="inline-flex items-center px-2 py-1 border border-transparent text-small font-medium rounded-lg shadow-sm text-black bg-indigo-300 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Your Reservations
                </a>
            </div>
        </section>



        <!-- Footer -->
        <x-footer></x-footer>
    </div>
</x-app-layout>
