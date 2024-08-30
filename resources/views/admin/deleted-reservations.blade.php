<x-app-layout>
    @include('layouts.navigation')
    <div class= "px-6 " style="margin-top: 6rem">
    <h1 class="text-2xl font-bold">Deleted Reservations</h1>
    <div class="py-6 px-4 sm:px-6 lg:px-8">
        @if($deletedReservations->count() > 0)
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Court Number</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach($deletedReservations as $reservation)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $reservation->user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $reservation->court->court_number }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $reservation->date }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $reservation->start_time }} - {{ $reservation->end_time }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $reservation->status }}</td>
                        <td class="px-6 py-4 whitespace-nowrap hover:bg-gray-50">
                            <!-- Restore Button -->
                            <form action="{{ route('admin.restore', $reservation->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-primary">Restore</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $deletedReservations->links() }}
            </div>
        @else
            <p class="text-gray-500">No deleted reservations found.</p>
        @endif

            <a href="{{ route('admin.index') }}" class="inline-block px-3 py-1 bg-orange-500 text-white font-semibold rounded-lg shadow-md hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                Back to Reservations
            </a>

    </div>
    </div>
</x-app-layout>
