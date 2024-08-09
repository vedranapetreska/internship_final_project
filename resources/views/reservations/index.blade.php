<x-app-layout>
    <!-- Page Content -->
    <div class="min-h-screen bg-gray-100">
        <!-- Standard Navigation -->
        @include('layouts.navigation')

        <section class="relative min-h-screen flex items-center justify-center bg-gray-400">

            <table class="table">
                <thead>
                <tr>
                    <th>Court Number</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                </tr>
                </thead>
                <tbody>
                @foreach($reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->court->court_number }}</td>
                        <td>{{ $reservation->start_time }}</td>
                        <td>{{ $reservation->end_time }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <a href="reservation">Book here</a>
        </section>
        <!-- Footer -->
        <x-footer></x-footer>

    </div>


</x-app-layout>

