<div class="w-full max-w-2xl bg-white shadow-md rounded-lg mb-6">
    <table class="min-w-full divide-y divide-gray-200 text-sm">
        <thead class="bg-gray-50">
        <tr>
            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Court Number</th>
            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Time</th>
            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Time</th>
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
        @foreach($reservations as $reservation)
            <tr>
                <td class="px-4 py-2 whitespace-nowrap">{{ $reservation->court->court_number }}</td>
                <td class="px-4 py-2 whitespace-nowrap">{{ $reservation->date}}</td>
                <td class="px-4 py-2 whitespace-nowrap">{{ $reservation->start_time }}</td>
                <td class="px-4 py-2 whitespace-nowrap">{{ $reservation->end_time }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
