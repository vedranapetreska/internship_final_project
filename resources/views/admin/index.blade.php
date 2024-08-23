<x-app-layout>
    @include('layouts.navigation')
    <section class="relative min-h-screen flex items-center justify-center bg-white" style="margin-top: 2rem">
        <div class="mt-4">
            <h1 class="text-3xl font-bold mb-6 text-gray-900">Reservations</h1>
            <p class="mb-4 text-gray-700 text-sm font-medium">
                <span class="font-bold text-indigo-600">Note:</span> Click on a reservation below if you want to change it.
            </p>

            <!-- Calendar Form -->
            <form action="{{ route('admin.index') }}" method="GET" class="mb-4">
                <label for="date" class="text-gray-700 font-medium">Select Date:</label>
                <input type="date" id="date" name="date" value="{{ request('date') }}" class="border rounded-lg p-2 w-full">
                <button type="submit" class="mt-2 bg-indigo-600 text-white p-2 rounded-lg">Show Reservations</button>
            </form>

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
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2">
                            {{ $reservation->user->name }}
                        </td>
                        <td class="border px-4 py-2">
                            {{ $reservation->user->email }}
                        </td>
                        <td class="border px-4 py-2">
                            {{ $reservation->court->court_number }}
                        </td>
                        <td class="border px-4 py-2">
                            {{ $reservation->date }}
                        </td>
                        <td class="border px-4 py-2">
                            {{ $reservation->start_time }}
                        </td>
                        <td class="border px-4 py-2">
                            {{ $reservation->end_time }}
                        </td>
                        <td class="border px-4 py-2">
                            <p class=" block w-full {{ $reservation->status == 'approved' ? 'text-green-600 font-bold' : ' ' }}">
                                {{ $reservation->status }}
                            </p>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>
    <x-footer></x-footer>
</x-app-layout>
