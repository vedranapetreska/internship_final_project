<x-app-layout>
    @include('layouts.navigation')
    <section class="relative min-h-screen flex items-center justify-center bg-white" style="margin-top: 2rem">
        <div class="mt-4">
            <h1 class="text-3xl font-bold mb-6 text-gray-900">Reservations</h1>
            <p class="mb-4 text-gray-700 text-sm font-medium">
                <span class="font-bold text-indigo-600">Note:</span> Click on a reservation below if you want to change it.
            </p>

            <form action="{{ route('admin.index') }}" method="GET" class="mb-4">
                <label for="date" class="text-gray-700 font-medium">Select Date:</label>
                <input type="date" id="date" name="date" value="{{ request('date') }}" class="border rounded-lg p-2 w-full">

                <label for="status" class="text-gray-700 font-medium mt-4">Select Status:</label>
                <select id="status" name="status" class="border rounded-lg p-2 w-full">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="denied" {{ request('status') == 'denied' ? 'selected' : '' }}>Denied</option>
                </select>

                <button type="submit" class="mt-2 bg-indigo-600 text-white p-2 rounded-lg">Show Reservations</button>
            </form>


            <table class="table-auto w-full bg-white rounded-lg shadow-md">
                <thead class="bg-orange-300 text-white">
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Court number</th>
                    <th>Date</th>
                    <th>Start time</th>
                    <th>End time</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($reservations as $reservation)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2">
                            {{ $reservation->user->name }}
                        </td>
                        <td class="border px-4 py-2">
                            {{ $reservation->user->email }}
                        </td>
                        <td class="border px-4 py-2">
                            {{ $reservation->court->court_number }}
                        </td>
                        <td class="border px-4 py-2">
                            {{ $reservation->date }}
                        </td>
                        <td class="border px-4 py-2">
                            {{ $reservation->start_time }}
                        </td>
                        <td class="border px-4 py-2">
                            {{ $reservation->end_time }}
                        </td>
                        <td class="border px-4 py-2">
                            <p class=" block w-full {{ $reservation->status == 'approved' ? 'text-green-600 font-bold' : ' ' }}">
                                {{ $reservation->status }}
                            </p>
                        </td>
                        @if($reservation->status == 'pending')
                            <td>
                                <form action="{{ route('admin.approveReservation', $reservation->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="bg-green-500 text-white p-2 rounded-lg">
                                        Approve Reservation
                                    </button>
                                </form>
                            </td>
                            <td>
                                <form action="{{ route('admin.denyReservation', $reservation->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="bg-red-400 text-white p-2 rounded-lg">
                                        Deny Reservation
                                    </button>
                                </form>
                            </td>
                        @elseif($reservation->status == 'approved')
                            <td>
                                <form action="{{ route('admin.denyReservation', $reservation->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="bg-red-400 text-white p-2 rounded-lg">
                                        Deny Reservation
                                    </button>
                                </form>
                            </td>
                        @elseif($reservation->status == 'denied')
                            <td>
                                <form action="{{ route('admin.approveReservation', $reservation->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="bg-green-500 text-white p-2 rounded-lg">
                                        Approve Reservation
                                    </button>
                                </form>
                            </td>
                        @endif
                    </tr>

                @endforeach
                </tbody>
            </table>

        </div>
    </section>
    <x-footer></x-footer>
</x-app-layout>
