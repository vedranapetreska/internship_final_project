@php use Carbon\Carbon; @endphp

@include('reservations.dates', ['slot' => $slot1])

<h1 class="mt-6 text-2xl font-semibold text-gray-600" style="flex-direction: row">
    Choose an available time slot to reserve your court
</h1>

<table class="w-full bg-white border-collapse text-sm mt-4">
    <thead class="bg-gray-100">
    <tr>
        @foreach($courtNumbers as $courtNumber)
            <th class="border border-gray-300 px-2 py-1 text-center {{ $loop->first ? '' : 'border-l-4' }}" colspan="2">Court {{ $courtNumber }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @php
        $now = Carbon::now();
        $selectedDate = Carbon::parse($date);
        $isToday = $selectedDate->isToday();
        $courts = $allSlotsReal;
//        dd($courts);
    @endphp
    @foreach ($courts[1]['slots'] as $index => $slot)
        <tr>
            @foreach ($courts as $court)
                    @php
                        $currentSlot = $court['slots'][$index];
                        if($index < count($court['slots']) - 1)
                            $nextSlot = $court['slots'][$index+1];

                        if($index < count($court['slots']) - 2)
                            $nextNextSlot = $court['slots'][$index+2]
                    @endphp
                @php
                    $start = Carbon::parse($currentSlot['start']);
//                    $start = $start->copy()->addMinutes(30);
//                    $end = $start->copy()->addMinutes(30);
                    $today = Carbon::today();
                @endphp
                @if($index % 2 == 0 && (!$isToday || ($isToday && $start->greaterThan($now))))
                    <td class="border border-gray-300 px-2 py-1 text-center shadow-lg {{ $currentSlot['status'] == 'approved' ? 'bg-red-400 text-white' : ($currentSlot['status'] == 'pending' ? 'bg-yellow-400 text-white' : 'bg-green-500 text-white') }} {{ $loop->first ? '' : 'border-l-4' }}">
                        @if ($currentSlot['status'] == 'approved')
                            {{ 'RESERVED' }}
                        @elseif ($currentSlot['status'] == 'pending')
                            {{ 'PENDING' }}
                        @else
                            <a href="{{ route('reservation.create') }}?court_number={{ $court['court_number'] }}&date={{ $date }}&start_time={{ $currentSlot['start'] }}&end_time={{ $nextSlot['end'] }}" class="block w-full bg-green-500 hover:bg-green-600 text-white">
                                {{ $currentSlot['start'] . '-' . $currentSlot['end'] }}
                            </a>
                        @endif
                    </td>
                    <td class="border border-gray-300 px-2 py-1 text-center shadow-lg {{ $nextSlot['status'] == 'approved' ? 'bg-red-400 text-white' : ($nextSlot['status'] == 'pending' ? 'bg-yellow-400 text-white' : 'bg-green-500 text-white') }}">
                        @if ($nextSlot['status'] == 'approved')
                            {{ 'RESERVED' }}
                        @elseif ($nextSlot['status'] == 'pending')
                            {{ 'PENDING' }}
                        @else
                            <a href="{{ route('reservation.create') }}?court_number={{ $court['court_number'] }}&date={{ $date }}&start_time={{ $nextSlot['start'] }}&end_time={{ $nextNextSlot['end'] }}" class="block w-full bg-green-500 hover:bg-green-600 text-white">
                                {{ $nextSlot['start'] . '-' . $nextSlot['end'] }}
                            </a>
                        @endif
                    </td>
                @elseif($index % 2 == 0 )
                    <td class="border border-gray-300 px-2 py-1 text-center shadow-lg  {{ $currentSlot['status'] == 'approved' ? 'bg-red-300 text-white' : ($currentSlot['status'] == 'pending' ? 'bg-yellow-300 text-white' : 'bg-green-400 text-white') }} {{ $loop->first ? '' : 'border-l-4' }}">
                        @if ($currentSlot['status'] == 'approved')
                            {{ 'RESERVED' }}
                        @elseif ($currentSlot['status'] == 'pending')
                            {{ 'PENDING' }}
                        @else
                            {{ $currentSlot['start'] . '-' . $currentSlot['end'] }}
                        @endif
                    </td>
                    <td class="border border-gray-300 px-2 py-1 text-center shadow-lg {{ $nextSlot['status'] == 'approved' ? 'bg-red-300 text-white' : ($nextSlot['status'] == 'pending' ? 'bg-yellow-300 text-white' : 'bg-green-400 text-white') }}">
                        @if ($nextSlot['status'] == 'approved')
                            {{ 'RESERVED' }}
                        @elseif ($nextSlot['status'] == 'pending')
                            {{ 'PENDING' }}
                        @else
                            {{ $nextSlot['start'] . '-' . $nextSlot['end'] }}

                        @endif
                    </td>
                @endif
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>

