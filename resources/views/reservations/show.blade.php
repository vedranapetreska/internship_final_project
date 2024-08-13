<!-- resources/views/reservations/user-reservations.blade.php -->
<x-app-layout>
    @include('layouts.navigation')
    <section class="relative min-h-screen flex items-center justify-center bg-gray-400">
        <div class="max-w-lg mx-auto p-6 bg-white shadow-md rounded-lg">
            <h1 class="text-3xl font-bold mb-6 text-gray-900">Your Reservations</h1>
            <p class="mb-4 text-gray-700 text-sm font-medium">
                <span class="font-bold text-indigo-600">Note:</span> Click on a reservation below if you want to change it.
            </p>

            <table class="table-auto w-full bg-white rounded-lg shadow-md">
                <thead class="bg-orange-300 text-white">
                <tr>
                    <th class="px-4 py-2">Court Number</th>
                    <th class="px-4 py-2">Start Time</th>
                    <th class="px-4 py-2">End Time</th>
                    <th class="px-4 py-2">Date</th>
                </tr>
                </thead>
                <tbody>
                @foreach($reservations as $reservation)
                    <tr>
                        <td class="border px-4 py-2 hover:bg-gray-50">
                            <a href="{{ route('reservation.edit', $reservation->id) }}" class="block w-full h-full"> {{ $reservation->court->court_number }} </a>
                        </td>
                        <td class="border px-4 py-2 hover:bg-gray-50">
                            <a href="{{ route('reservation.edit', $reservation->id) }}" class="block w-full h-full"> {{ $reservation->start_time }} </a>
                        </td>
                        <td class="border px-4 py-2 hover:bg-gray-50">
                            <a href="{{ route('reservation.edit', $reservation->id) }}" class="block w-full h-full"> {{ $reservation->end_time }} </a>
                        </td>
                        <td class="border px-4 py-2 hover:bg-gray-50">
                            <a href="{{ route('reservation.edit', $reservation->id) }}" class="block w-full h-full"> {{ $reservation->date }} </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <a href="{{ route('reservation.create') }}" class="mt-6 inline-block bg-orange-300 text-white font-bold py-2 px-4 rounded-full hover:bg-orange-400 transition duration-300 ease-in-out">
                Make a reservation
            </a>
        </div>
    </section>
    <x-footer></x-footer>
</x-app-layout>
