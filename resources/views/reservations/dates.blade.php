<div class="w-full max-w-sm">
    <form method="GET" action='{{$slot}}' class="flex items-center">
        <label for="date" class="block text-sm font-medium text-gray-700 mr-2">Select a Day of the Week</label>
        <select name="date" id="date" class="p-1 border border-gray-300 rounded-md mr-2">
            @foreach($datesForWeek as $availableDate)
                <option value="{{ $availableDate }}" {{ $availableDate == $date ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::parse($availableDate)->format('l, F j, Y') }}
                </option>
            @endforeach
        </select>
        <input type="submit" class="bg-orange-400 hover:bg-orange-500 text-white px-2 py-1 rounded-md" value="Show">
    </form>
</div>
