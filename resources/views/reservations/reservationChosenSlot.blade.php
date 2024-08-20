<table class="w-full bg-white border-collapse text-sm mt-4">
    <thead class="bg-gray-100">
    <tr>
        <th class="border border-gray-300 px-2 py-1 text-center" colspan="2">Court {{ $courtNumber }}</th>
    </tr>
    </thead>
    <tbody>
    @php
        $court = $allSlotsReal[$courtNumber-1]; // Get the selected court's data
    @endphp
    @foreach ($court['allSlots'] as $index => $slot)
        @if ($index % 2 == 0) <!-- This condition ensures that slots are paired -->
        @php
            $currentSlot = $court['allSlots'][$index];
            if($index < count($court['allSlots']) - 1)
            $nextSlot = $court['allSlots'][$index+1];

            if($index < count($court['allSlots']) - 2)
            $nextNextSlot = $court['allSlots'][$index+2]
//
        @endphp
        <tr>
            <td class="border border-gray-300 px-2 py-1 text-center {{ $currentSlot['reserved'] ? 'bg-red-500 text-white' : 'bg-green-500 text-white' }}">
                @if ($currentSlot['reserved'])
                    {{ 'RESERVED' }}
                @else
                    <a href="/reservations/create?court_number={{ $courtNumber }}&date={{ $date }}&start_time={{ $currentSlot['start'] }}&end_time={{ $nextSlot['end'] }}" class="bg-green-500 hover:bg-green-600 text-white">
                        {{ $currentSlot['start'] . '-' . $currentSlot['end'] }}
                    </a>
                @endif
            </td>

                <td class="border border-gray-300 px-2 py-1 text-center {{ $nextSlot['reserved'] ? 'bg-red-500 text-white' : 'bg-green-500 text-white' }}">
                    @if ($nextSlot['reserved'])
                        {{ 'RESERVED' }}
                    @else
                        <a href="/reservations/create?court_number={{ $courtNumber }}&date={{ $date }}&start_time={{ $nextSlot['start'] }}&end_time={{ $nextNextSlot['end'] }}" class="bg-green-500 hover:bg-green-600 text-white">
                            {{ $nextSlot['start'] . '-' . $nextSlot['end'] }}
                        </a>
                    @endif
                </td>



        </tr>
        @endif
    @endforeach
    </tbody>
</table>
