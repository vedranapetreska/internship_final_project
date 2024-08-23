@php use Carbon\Carbon; @endphp
<form action="{{ route('reservation.store') }}" method="POST">
    @csrf

    <div class="mb-4 " style="margin-top: 3rem">

        <label for="court_id" class="block text-sm font-medium text-gray-700">Select Court</label>
        <select name="court_id" id="court_id" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            <option value="" disabled selected>Select a court</option>
            @foreach($courts as $court)
                <option value="{{ $court->id }}" {{ $courtNumber == $court->id ? 'selected' : '' }}>
                    {{ $court->court_number }}
                </option>
            @endforeach
        </select>
        @error('court_id')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    @php

        $today = Carbon::today()->format('Y-m-d');
        $maxDate = Carbon::today()->addDays(6)->format('Y-m-d');
    @endphp

    <div class="mb-4">
        <label for="date" class="block text-sm font-medium text-gray-700">Reservation Date</label>
        <input type="date" name="date" id="date" value="{{ $date1 }}"
               min="{{ $today }}" max="{{ $maxDate }}"
               class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
               required>
        @error('date')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time</label>
        <style>
            input[type="time"]::-webkit-calendar-picker-indicator {
                display: none;
            }

            input[type="time"]::-webkit-inner-spin-button,
            input[type="time"]::-webkit-clear-button {
                display: none;
            }
        </style>
        <input type="time" name="start_time" id="start_time"  value="{{ $startTime }}"
               min="07:00"
               max="21:00"
               step="1800" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
        @error('start_time')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label for="end_time" class="block text-sm font-medium text-gray-700">End Time</label>
        <input type="time" name="end_time" id="end_time" value="{{ $endTime }}"
               min="08:00"
               max="22:00"
               class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
        @error('end_time')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-x-4 flex" style="margin-top:8rem;display: flex;justify-content: center;align-items: center">
        <button type="submit" class="inline-flex items-center px-4 py-1 border border-transparent text-base font-medium rounded-lg shadow-sm text-black bg-customGreen hover:bg-green-900
         focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" style="width:auto;height: 2.5rem">
            Reserve
        </button>

        <a href="{{ route('reservation.show') }}" class="inline-flex items-center px-3 py-2 border border-transparent text-small font-medium rounded-lg shadow-sm text-black bg-indigo-300 hover:bg-indigo-700 focus:outline-none
        focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" style="width:auto;height: 2.5rem">
            Your Reservations
        </a>
    </div>
</form>
