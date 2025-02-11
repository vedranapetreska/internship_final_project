<x-app-layout>

@include('layouts.navigation')
<section class="relative min-h-screen flex items-center justify-center bg-gray-400" style="margin-top: 4rem">
    <div class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded-lg">
        <h1 class="text-3xl font-bold mb-6 text-gray-900">Your Reservations</h1>
        <p class="mb-4 text-gray-700 text-sm font-medium">
            <span class="font-bold text-indigo-600">Note:</span>   You have the option to edit your <span class=" text-black font-bold">pending</span> reservation by selecting it below.
        </p>

        <table class="table-auto w-full bg-white rounded-lg shadow-md">
            <thead class="bg-orange-300 text-white">
            <tr>
                <th class="px-4 py-2">Court Number</th>
                <th class="px-4 py-2">Start Time</th>
                <th class="px-4 py-2">End Time</th>
                <th class="px-4 py-2">Date</th>
                <th class="px-4 py-2">Status</th>
            </tr>
            </thead>
            <tbody>
            @foreach($reservations as $reservation)
                @if($reservation->status=='pending')
                    <tr class="hover:bg-gray-100">
                @else
                    <tr>
                @endif
                    @if($reservation->status=='pending')
                        <td class="border px-4 py-2">
                            <a href="{{ route('reservation.edit', $reservation->id) }}?court_number={{$reservation->court->court_number}}&start_time={{$reservation->start_time}}&end_time={{ $reservation->end_time}}&date={{$reservation->date}}&status={{$reservation->status}}" class="block w-full h-full"> {{ $reservation->court->court_number }} </a>
                        </td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('reservation.edit', $reservation->id) }}?court_number={{$reservation->court->court_number}}&start_time={{$reservation->start_time}}&end_time={{ $reservation->end_time}}&date={{$reservation->date}}&status={{$reservation->status}}" class="block w-full h-full"> {{ $reservation->start_time }} </a>
                        </td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('reservation.edit', $reservation->id) }}?court_number={{$reservation->court->court_number}}&start_time={{$reservation->start_time}}&end_time={{ $reservation->end_time}}&date={{$reservation->date}}&status={{$reservation->status}}" class="block w-full h-full"> {{ $reservation->end_time }} </a>
                        </td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('reservation.edit', $reservation->id) }}?court_number={{$reservation->court->court_number}}&start_time={{$reservation->start_time}}&end_time={{ $reservation->end_time}}&date={{$reservation->date}}&status={{$reservation->status}}" class="block w-full h-full"> {{ $reservation->date }} </a>
                        </td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('reservation.edit', $reservation->id) }}?court_number={{$reservation->court->court_number}}&start_time={{$reservation->start_time}}&end_time={{ $reservation->end_time}}&date={{$reservation->date}}&status={{$reservation->status}}"
                             class="block w-full {{ $reservation->status == 'approved' ? 'text-green-600 font-bold' : '' }}
                             {{ $reservation->status == 'pending' ? 'text-yellow-400 font-bold' : ''}}
                             {{ $reservation->status == 'denied' ? 'text-red-400 font-bold' : ''}}">
                                {{ $reservation->status }} </a>
                        </td>
                    @else
                        <td class="border px-4 py-2">
                           {{ $reservation->court->court_number }}
                        </td>
                        <td class="border px-4 py-2">
                             {{ $reservation->start_time }}
                        </td>
                        <td class="border px-4 py-2">
                            {{ $reservation->end_time }}
                        </td>
                        <td class="border px-4 py-2">
                            {{ $reservation->date }}
                        </td>
                        <td class="border px-4 py-2
                            {{ $reservation->status == 'approved' ? 'text-green-600 font-bold' : '' }}
                            {{ $reservation->status == 'denied' ? 'text-red-400 font-bold' : '' }}">
                            {{ $reservation->status == 'canceled' ? 'text-black-400 font-bold' : '' }}
                            {{$reservation->status}}
                        </td>
                    @endif
                    <td>
                        @if($reservation->status !== 'canceled' && $reservation->status !== 'denied')
                            @include('reservations.button-cancel')
                        @endif

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        @if (session('error'))
            <div class="alert alert-danger text-red-600 mt-3">
                {{ session('error') }}
            </div>
        @endif

        <a href="{{ route('reservation.index') }}" class="mt-6 inline-block bg-orange-300 text-white font-bold py-2 px-4 rounded-full hover:bg-orange-400 transition duration-300 ease-in-out">
            Make a reservation
        </a>
    </div>
</section>
<x-footer></x-footer>
</x-app-layout>
