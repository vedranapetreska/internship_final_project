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
    <tbody class="overflow-y-auto" style="max-height: 400px">
    @foreach($reservations as $reservation)
        <tr class="hover:bg-gray-50">
            <td class="border px-4 py-2">{{ $reservation->user->name }}</td>
            <td class="border px-4 py-2">{{ $reservation->user->email }}</td>
            <td class="border px-4 py-2">{{ $reservation->court->court_number }}</td>
            <td class="border px-4 py-2">{{ $reservation->date }}</td>
            <td class="border px-4 py-2">{{ $reservation->start_time }}</td>
            <td class="border px-4 py-2">{{ $reservation->end_time }}</td>
            <td class="border px-4 py-2">
                <p class="block w-full {{ $reservation->status == 'approved' ? 'text-green-600 font-bold' : '' }}">
                    {{ $reservation->status }}
                </p>
            </td>
            <td class="border px-4 py-2 flex space-x-2">
                @if ($reservation->status == 'pending' && ($reservation->date >= now()->format('Y-m-d')))
                    @include('admin.button-approve')
                    @include('admin.button-deny')
                @elseif($reservation->status == 'approved' && ($reservation->date >= now()->format('Y-m-d')))
                    @include('admin.button-deny')
                @elseif($reservation->status == 'denied' && ($reservation->date >= now()->format('Y-m-d')))
                    @include('admin.button-approve')
                @endif
                @include('admin.button-delete')
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class="flex justify-between items-center mt-4 mb-6">
    <a href="{{ $reservations->previousPageUrl() }}" class="px-4 py-2 text-sm font-medium text-white bg-gray-400 rounded-md hover:bg-gray-500">
        Previous
    </a>

    <a href="{{ $reservations->nextPageUrl() }}" class="px-4 py-2 text-sm font-medium text-white bg-gray-400 rounded-md hover:bg-gray-500">
        Next
    </a>
</div>
