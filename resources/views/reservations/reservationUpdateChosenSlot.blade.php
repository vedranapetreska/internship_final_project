@php use Carbon\Carbon; @endphp
<table class="w-full bg-white border-collapse text-sm mt-4">
    <thead class="bg-gray-100">
    <tr>
        <th class="border border-gray-300 px-2 py-1 text-center" colspan="2">Court {{ $courtNumber }}</th>
    </tr>
    </thead>
    <tbody>
    @php
        $now = Carbon::now();
        $selectedDate = Carbon::parse($date);
        $isToday = $selectedDate->isToday();
        $court = $allSlotsReal[$courtNumber];
    @endphp
    @foreach ($court['slots'] as $index => $slot)
        @if ($index % 2 == 0) <!-- This condition ensures that slots are paired -->
        @php
            $currentSlot = $court['slots'][$index];
            if($index < count($court['slots']) - 1)
                $nextSlot = $court['slots'][$index+1];

            if($index < count($court['slots']) - 2)
                $nextNextSlot = $court['slots'][$index+2];

            $start = Carbon::parse($currentSlot['start']);
        @endphp
        @if ($index % 2 == 0 && (!$isToday || ($isToday && $start->greaterThan($now))))
            <tr>
            <td class="border border-gray-300 px-2 py-1 text-center {{ $currentSlot['status'] == 'approved' ? 'bg-red-400 text-white' : ($currentSlot['status'] == 'pending' ? 'bg-yellow-400 text-white' : 'bg-green-500 text-white') }}">
                @if ($currentSlot['status'] == 'approved')
                    {{ 'RESERVED' }}
                @elseif ($currentSlot['status'] == 'pending')
                    {{ 'PENDING' }}
                @else
                    <a href="{{route('reservation.edit', $reservation->id)}}?court_number={{ $courtNumber }}&date={{ $date }}&start_time={{ $currentSlot['start'] }}&end_time={{ $nextSlot['end'] }}" class="block w-full bg-green-500 hover:bg-green-600 text-white">
                        {{ $currentSlot['start'] . '-' . $currentSlot['end'] }}
                    </a>
                @endif
            </td>

            <td class="border border-gray-300 px-2 py-1 text-center  {{ $nextSlot['status'] == 'approved' ? 'bg-red-400 text-white' : ($nextSlot['status'] == 'pending' ? 'bg-yellow-400 text-white' : 'bg-green-500 text-white') }}">
                @if ($nextSlot['status'] == 'approved')
                    {{ 'RESERVED' }}
                @elseif ($nextSlot['status'] == 'pending')
                    {{ 'PENDING' }}
                @else
                    <a href="{{route('reservation.edit', $reservation->id)}}?court_number={{ $courtNumber }}&date={{ $date }}&start_time={{ $currentSlot['start'] }}&end_time={{ $nextSlot['end'] }}" class="block w-full bg-green-500 hover:bg-green-600 text-white">
                        {{ $currentSlot['start'] . '-' . $currentSlot['end'] }}
                    </a>
                @endif
            </td>
                @else
                    <td class="border border-gray-300 px-2 py-1 text-center {{ $currentSlot['status'] == 'approved' ? 'bg-red-300 text-white' : ($currentSlot['status'] == 'pending' ? 'bg-yellow-300 text-white' : 'bg-green-400 text-white') }}">
                        @if ($currentSlot['status'] == 'approved')
                            {{ 'RESERVED' }}
                        @elseif ($currentSlot['status'] == 'pending')
                            {{ 'PENDING' }}
                        @else
                            {{ $currentSlot['start'] . '-' . $currentSlot['end'] }}
                        @endif
                    </td>

                    <td class="border border-gray-300 px-2 py-1 text-center  {{ $nextSlot['status'] == 'approved' ? 'bg-red-300 text-white' : ($nextSlot['status'] == 'pending' ? 'bg-yellow-300 text-white' : 'bg-green-400 text-white') }}">
                        @if ($nextSlot['status'] == 'approved')
                            {{ 'RESERVED' }}
                        @elseif ($nextSlot['status'] == 'pending')
                            {{ 'PENDING' }}
                        @else
                            {{ $currentSlot['start'] . '-' . $currentSlot['end'] }}

                        @endif
                    </td>

            </tr>
        @endif

        @endif
    @endforeach
    </tbody>
</table>
