<x-app-layout>
    @include('layouts.navigation')
    <section class="relative min-h-screen flex items-center justify-center bg-gray-400">
        <div class="max-w-lg mx-auto p-6 bg-white shadow-md rounded-lg">
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
            <form action="{{ route('reservation.update', $reservation->id) }}" method="POST">
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
                    <input type="date" name="date" value="{{ old('date', $reservation->date) }}" id="date" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                    @error('date')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time</label>
                    <input type="time" name="start_time" value="{{ old('start_time', $reservation->start_time) }}" id="start_time" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                    @error('start_time')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="end_time" class="block text-sm font-medium text-gray-700">End Time</label>
                    <input type="time" name="end_time" value="{{ old('end_time', $reservation->end_time) }}" id="end_time" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                    @error('end_time')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                    <button type="submit" class="inline-flex items-center px-3 py-1 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-customGreen hover:bg-green-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Update
                    </button>
            </form>

            <form action="{{ route('reservation.destroy', $reservation->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this reservation?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center px-3 py-1 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Delete
                </button>
            </form>
        </div>
    </section>
    <x-footer></x-footer>
</x-app-layout>
