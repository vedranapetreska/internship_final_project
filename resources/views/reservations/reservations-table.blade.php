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

                        if($index < count($court['allSlots']) - 2)
                        $nextNextSlot = $court['allSlots'][$index+2]
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
                            <a href="/reservations/create?court_number={{$court['court_number']}}&date={{$date}}&start_time={{$currentSlot['start']}}&end_time={{$nextSlot['end']}}" class="bg-green-500 hover:bg-green-600 text-white">
                                {{ $currentSlot['start'] . '-' . $currentSlot['end'] }}
                            </a>
                        @endif
                    </td>
                    <td class="border border-gray-300 px-2 py-1 text-center {{ $nextSlot['reserved'] ? 'bg-red-500 text-white' : 'bg-green-500 text-white' }}">
                        @if ($nextSlot['reserved'])
                            {{ 'RESERVED' }}
                        @else
                            <a href="/reservations/create?court_number={{$court['court_number']}}&date={{$date}}&start_time={{$nextSlot['start']}}&end_time={{$nextNextSlot['end']}}" class="bg-green-500 hover:bg-green-600 text-white">
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

