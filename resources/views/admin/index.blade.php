<x-app-layout>
    @include('layouts.navigation')
    <section class="relative min-h-screen flex items-center justify-center bg-gray-400" style="margin-top: 2rem">
        <div class="max-w-lg mx-auto p-6 bg-white shadow-md rounded-lg" style="flex-direction: column">
            <h1 class="text-3xl font-bold mb-6 text-gray-900">Reservations</h1>
            <p class="mb-4 text-gray-700 text-sm font-medium">
                <span class="font-bold text-indigo-600">Note:</span> Click on a reservation below if you want to change it.
            </p>

            <table class="table-auto w-full bg-white rounded-lg shadow-md">
                <thead class="bg-orange-300 text-white">
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Court number</th>
                    <th>Date</th>
                    <th>Start time</th>
                    <th>End time</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->user->name }}</td>
                        <td>{{ $reservation->user->email }}</td>
                        <td>{{ $reservation->court->court_number }}</td>
                        <td>{{ $reservation->date }}</td>
                        <td>{{ $reservation->start_time }}</td>
                        <td>{{ $reservation->end_time }}</td>
                        <td>{{ $reservation->status }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>
    <x-footer></x-footer>
</x-app-layout>

