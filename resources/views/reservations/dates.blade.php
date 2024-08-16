<div class="w-full max-w-sm shadow-md mb-4 p-4">
    <form method="GET" action='{{$slot}}'>
        <label for="date" class="block text-sm font-small text-gray-700 mb-2">Select a Day of the Week</label>
        <select name="date" id="date" class="p-2 border border-gray-300 rounded-md mb-4">
            @foreach($datesForWeek as $availableDate)
                <option value="{{ $availableDate }}" {{ $availableDate == $date ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::parse($availableDate)->format('l, F j, Y') }}
                </option>
            @endforeach
        </select>
        <input type="submit" class="bg-orange-400 text-white px-2 py-1" value="Show Available Slots">
    </form>
</div>
