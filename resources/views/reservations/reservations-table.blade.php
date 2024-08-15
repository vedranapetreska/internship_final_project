<div class="container mx-auto mt-10">
    @include('reservations.dates', ['slot' => $slot1])
    <!-- Dropdown Table for Free Slots -->
    <div class="bg-white shadow-md rounded-lg p-4">
        <h2 class="text-lg font-semibold mb-2 text-center">Available Slots</h2>
        <div class="relative">
            <button id="dropdownButton" class="bg-blue-500 text-white px-4 py-2 rounded-md w-full">Select Court</button>
            <div id="dropdownMenu" class="absolute mt-2 w-full bg-white shadow-lg rounded-lg hidden">
                @foreach($freeSlotsByCourt as $courtId => $data)
                    <div class="p-2 border-b border-gray-200">
                        <h3 class="text-md font-semibold">Court {{ $data['court_number'] }}</h3>
                        <table class="min-w-full divide-y divide-gray-200 text-sm mt-2">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-2 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Time</th>
                                <th class="px-2 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Time</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($data['slots'] as $slot)
                                <tr class="bg-green-100">
                                    <td class="px-2 py-1 whitespace-nowrap">{{ $slot['start'] }}</td>
                                    <td class="px-2 py-1 whitespace-nowrap">{{ $slot['end'] }}</td>
                                </tr>
                            @endforeach
                            @foreach($reservations->where('court_id', $courtId)->where('date', $date) as $reserved)
                                <tr class="bg-red-100">
                                    <td class="px-2 py-1 whitespace-nowrap">{{ $reserved->start_time }}</td>
                                    <td class="px-2 py-1 whitespace-nowrap">{{ $reserved->end_time }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('dropdownButton').addEventListener('click', function() {
        const menu = document.getElementById('dropdownMenu');
        menu.classList.toggle('hidden');
    });
</script>



{{--<!-- Reservations -->--}}
{{--<div class="w-full max-w-2xl bg-white shadow-md rounded-lg mb-6">--}}
{{--    <table class="min-w-full divide-y divide-gray-200 text-sm">--}}
{{--        <thead class="bg-gray-50">--}}
{{--        <tr>--}}
{{--            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Court Number</th>--}}
{{--            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>--}}
{{--            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Time</th>--}}
{{--            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Time</th>--}}
{{--        </tr>--}}
{{--        </thead>--}}
{{--        <tbody class="bg-white divide-y divide-gray-200">--}}
{{--        @foreach($reservations as $reservation)--}}
{{--            <tr>--}}
{{--                <td class="px-4 py-2 whitespace-nowrap">{{ $reservation->court->court_number }}</td>--}}
{{--                <td class="px-4 py-2 whitespace-nowrap">{{ $reservation->date }}</td>--}}
{{--                <td class="px-4 py-2 whitespace-nowrap">{{ $reservation->start_time }}</td>--}}
{{--                <td class="px-4 py-2 whitespace-nowrap">{{ $reservation->end_time }}</td>--}}
{{--            </tr>--}}
{{--        @endforeach--}}
{{--        </tbody>--}}
{{--    </table>--}}
{{--</div>--}}
