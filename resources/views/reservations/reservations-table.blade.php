@php use Carbon\Carbon; @endphp

@include('reservations.dates', ['slot' => $slot1])

<table class="w-full bg-white border-collapse text-sm mt-4">
    <thead class="bg-gray-100">
    <tr>
        @foreach($courtNumbers as $courtNumber)
            <th class="border border-gray-300 px-2 py-1 text-center " colspan="2">Court {{ $courtNumber }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @php
        $courts = $allSlotsReal;
    @endphp
    @foreach ($courts[0]['allSlots'] as $index => $slot)
        <tr>
            @foreach ($courts as $court)
                    @php
                        $currentSlot = $court['allSlots'][$index];
                        if($index < count($court['allSlots']) - 1)
                        $nextSlot = $court['allSlots'][$index+1];
//
                    @endphp
                @php
                    $start = Carbon::parse($currentSlot['start']);
                    $start = $start->copy()->addMinutes(30);
                    $end = $start->copy()->addMinutes(30);
                @endphp
                @if($index%2==0)
                    <td class="border border-gray-300 px-2 py-1 text-center {{ $currentSlot['reserved'] ? 'bg-red-500 text-white' : 'bg-green-500 text-white' }}">
                        @if ($currentSlot['reserved'])
                            {{ 'RESERVED' }}
                        @else
                            <a href="/reservations/create" class="bg-green-500 hover:bg-green-600 text-white">
                                {{ $currentSlot['start'] . '-' . $currentSlot['end'] }}
                            </a>
                        @endif
                    </td>
                    <td class="border border-gray-300 px-2 py-1 text-center {{ $nextSlot['reserved'] ? 'bg-red-500 text-white' : 'bg-green-500 text-white' }}">
                        @if ($nextSlot['reserved'])
                            {{ 'RESERVED' }}
                        @else
                            <a href="/reservations/create" class="bg-green-500 hover:bg-green-600 text-white">
                                {{ $nextSlot['start'] . '-' . $nextSlot['end'] }}
                            </a>
                        @endif
                    </td>
                @endif
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>



{{--</div>--}}

{{-- Code below is commented out, so no changes are made to it --}}

{{-- <div class="container mx-auto mt-10"> --}}
{{--     @include('reservations.dates', ['slot' => $slot1]) --}}
{{--     <!-- Dropdown Table for Free Slots --> --}}
{{--     <div class="bg-white shadow-md rounded-lg p-4"> --}}
{{--         <h2 class="text-lg font-semibold mb-2 text-center">Available Slots</h2> --}}
{{--         <div class="relative"> --}}
{{--             <button id="dropdownButton" class="bg-orange-400 text-white px-4 py-2 rounded-md w-full">Select Court</button> --}}
{{--             <div id="dropdownMenu" class="absolute mt-2 w-full bg-white shadow-lg rounded-lg hidden"> --}}
{{--                 @foreach($freeSlotsByCourt as $courtId => $data) --}}
{{--                     <div class="p-2 border-b border-gray-200"> --}}
{{--                         <h3 class="text-md font-semibold">Court {{ $data['court_number'] }}</h3> --}}
{{--                         <table class="min-w-full divide-y divide-gray-200 text-sm mt-2"> --}}
{{--                             <thead class="bg-gray-50"> --}}
{{--                             <tr> --}}
{{--                                 <th class="px-2 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Time</th> --}}
{{--                                 <th class="px-2 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Time</th> --}}
{{--                             </tr> --}}
{{--                             </thead> --}}
{{--                             <tbody class="bg-white divide-y divide-gray-200"> --}}
{{--                             @foreach($data['slots'] as $slot) --}}
{{--                                 <tr class="bg-green-100"> --}}
{{--                                     <td class="px-2 py-1 whitespace-nowrap">{{ $slot['start'] }}</td> --}}
{{--                                     <td class="px-2 py-1 whitespace-nowrap">{{ $slot['end'] }}</td> --}}
{{--                                 </tr> --}}
{{--                             @endforeach --}}
{{--                             @foreach($reservations->where('court_id', $courtId)->where('date', $date) as $reserved) --}}
{{--                                 <tr class="bg-red-100"> --}}
{{--                                     <td class="px-2 py-1 whitespace-nowrap">{{ $reserved->start_time }}</td> --}}
{{--                                     <td class="px-2 py-1 whitespace-nowrap">{{ $reserved->end_time }}</td> --}}
{{--                                 </tr> --}}
{{--                             @endforeach --}}
{{--                             </tbody> --}}
{{--                         </table> --}}
{{--                     </div> --}}
{{--                 @endforeach --}}
{{--             </div> --}}
{{--         </div> --}}
{{--     </div> --}}
{{-- </div> --}}

{{-- <script>--}}
{{--     document.getElementById('dropdownButton').addEventListener('click', function() {--}}
{{--         const menu = document.getElementById('dropdownMenu');--}}
{{--         menu.classList.toggle('hidden');--}}
{{--     });--}}
{{-- </script>--}}

{{-- <!-- Reservations --> --}}
{{-- <div class="w-full max-w-2xl bg-white shadow-md rounded-lg mb-6"> --}}
{{--     <table class="min-w-full divide-y divide-gray-200 text-sm"> --}}
{{--         <thead class="bg-gray-50"> --}}
{{--         <tr> --}}
{{--             <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Court Number</th> --}}
{{--             <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th> --}}
{{--             <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Time</th> --}}
{{--             <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Time</th> --}}
{{--         </tr> --}}
{{--         </thead> --}}
{{--         <tbody class="bg-white divide-y divide-gray-200"> --}}
{{--         @foreach($reservations as $reservation) --}}
{{--             <tr> --}}
{{--                 <td class="px-4 py-2 whitespace-nowrap">{{ $reservation->court->court_number }}</td> --}}
{{--                 <td class="px-4 py-2 whitespace-nowrap">{{ $reservation->date }}</td> --}}
{{--                 <td class="px-4 py-2 whitespace-nowrap">{{ $reservation->start_time }}</td> --}}
{{--                 <td class="px-4 py-2 whitespace-nowrap">{{ $reservation->end_time }}</td> --}}
{{--             </tr> --}}
{{--         @endforeach --}}
{{--         </tbody> --}}
{{--     </table> --}}
{{-- </div> --}}
