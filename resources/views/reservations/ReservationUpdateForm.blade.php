<style>
    input[type="time"]::-webkit-calendar-picker-indicator {
        display: none;
    }
    input[type="time"]::-webkit-inner-spin-button,
    input[type="time"]::-webkit-clear-button {
        display: none;
    }
</style>
<form action="{{ route('reservation.update', $reservation->id) }}" method="POST" class="mb-6">
    @csrf
    @method('PUT')

    <div class="mb-5">
        <label for="court_id" class="block text-sm font-medium text-gray-700">Select Court</label>
        <select name="court_id" id="court_id" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            <option value="" disabled>Select a court</option>
            @foreach($courts as $court)
                <option value="{{ $court->id }}" {{ old('court_id', $reservation->court_id) == $court->id ? 'selected' : '' }}>
                    {{ $court->court_number }}
                </option>
            @endforeach
        </select>
        @error('court_id')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-5">
        <label for="date" class="block text-sm font-medium text-gray-700">Reservation Date</label>
        <input type="date" name="date" value="{{ $date1 }}" id="date" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
        @error('date')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-5">
        <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time</label>
        <input type="time" name="start_time" value="{{ $startTime }}" id="start_time"
               min="08:00"
               max="22:00"
               step="1800"
               class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
        @error('start_time')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-5">
        <label for="end_time" class="block text-sm font-medium text-gray-700">End Time</label>
        <input type="time" name="end_time" value="{{ $endTime }}" id="end_time"
               min="08:00"
               max="22:00"
               step="1800"
               class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
        @error('end_time')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-x-4 flex" style="margin-top:3rem;display: flex;justify-content: center;align-items: center">
        <button type="submit" class="inline-flex items-center px-4 py-1 border border-transparent text-base font-medium rounded-lg shadow-sm text-black bg-customGreen hover:bg-green-900
                          focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" style="width:auto;height: 2.5rem">
            Update
        </button>
    </div>
</form>
