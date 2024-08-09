<x-app-layout>
@include('layouts.navigation')
<section class="relative min-h-screen flex items-center justify-center bg-gray-400">
    <div class="max-w-lg mx-auto p-6 bg-white shadow-md rounded-lg">
        <h1 class="text-3xl font-bold mb-6 text-gray-900">Make a Reservation</h1>

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

        <form action="{{ route('reservation.store') }}" method="POST">
            @csrf

            <div class="mb-5">
                <label for="court_id" class="block text-sm font-medium text-gray-700">Select Court</label>
                <select name="court_id" id="court_id" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                    <option value="" disabled selected>Select a court</option>
                    @foreach($courts as $court)
                        <option value="{{ $court->id }}">{{ $court->court_number }}</option>
                    @endforeach
                </select>
                @error('court_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="date" class="block text-sm font-medium text-gray-700">Reservation Date</label>
                <input type="date" name="date" id="date" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                @error('date')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time</label>
                <input type="time" name="start_time" id="start_time" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                @error('start_time')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="end_time" class="block text-sm font-medium text-gray-700">End Time</label>
                <input type="time" name="end_time" id="end_time" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                @error('end_time')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-black bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Reserve
            </button>
        </form>
    </div>


</section>

    <x-footer></x-footer>
</x-app-layout>
