<x-app-layout>
    <style>
        input[type="time"]::-webkit-calendar-picker-indicator {
            display: none;
        }

        input[type="time"]::-webkit-inner-spin-button,
        input[type="time"]::-webkit-clear-button {
            display: none;
        }
    </style>
    @include('layouts.navigation')
    <section class="relative min-h-screen flex items-center justify-center bg-gray-400" style="margin-top:2rem">
        <div style="display: flex;flex-direction: column">
        <div class="flex flex-row justify-between max-w-4xl mx-auto p-4 space-x-4">
            <div class="flex-1 bg-white shadow-md rounded-lg p-3 mt-6">
                <div class="w-full max-w-sm flex justify-center flex-col items-center">
                    <p class="border-2 border-black bg-gray-100 text-center text-xl font-medium py-2 rounded-md shadow-md mt-4" style="width:10rem">
                        {{ $date }}
                    </p>
                </div>

                @include('reservations.reservationUpdateChosenSlot')
            </div>
            <div class="flex-1 bg-white shadow-md rounded-lg p-4 max-h-[80vh] overflow-auto mt-6" style="width: 40rem">
                <h1 class="text-3xl font-bold mb-6 text-gray-900">Edit Reservation</h1>

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        <strong class="font-bold">Error:</strong>
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        <strong class="font-bold">Success:</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <!-- Update Form -->
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

                <!-- Delete Form -->
                <form action="{{ route('reservation.destroy', $reservation->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this reservation?');">
                    @csrf
                    @method('DELETE')
                    <div class="space-x-4 flex" style="margin-top:3rem;display: flex;justify-content: center;align-items: center">
                        <button type="submit" class="inline-flex items-center px-4 py-1 border border-transparent text-base font-medium rounded-lg shadow-sm text-black bg-red-500 hover:bg-green-900
                          focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" style="width:auto;height: 2.5rem">
                            Delete
                        </button>
                    </div>
                </form>
            </div>
        </div>
            <a href="{{ route('reservation.show') }}" class="mt-1 inline-flex items-center px-4 py-2 text-base font-medium text-white rounded-full shadow-md hover:bg-gray-300 transition duration-300" style="flex-direction: column">
                <- Back to your reservations
            </a>

        </div>
    </section>
    <x-footer></x-footer>
</x-app-layout>
