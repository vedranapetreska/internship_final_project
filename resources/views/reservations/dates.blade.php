<div class="w-full max-w-lg bg-white shadow-md rounded-lg mb-4 p-4">
    <form method="GET" action='{{$slot}}'>
        <label for="date" class="block text-sm font-medium text-gray-700 mb-2">Select a Day of the Week</label>
        <select name="date" id="date" class="block w-full p-2 border border-gray-300 rounded-md mb-4">
            @foreach($datesForWeek as $availableDate)
                <option value="{{ $availableDate }}" {{ $availableDate == $date ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::parse($availableDate)->format('l, F j, Y') }}
                </option>
            @endforeach
        </select>
        <input type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md w-full" value="Show Available Slots">
    </form>
</div>
