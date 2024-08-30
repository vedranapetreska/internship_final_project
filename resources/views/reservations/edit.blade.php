<x-app-layout>
    @include('layouts.navigation')
    <section class="relative min-h-screen flex items-center justify-center bg-gray-400" style="margin-top:2rem">
        <div style="display: flex;flex-direction: column">
            <div class="flex flex-row justify-between max-w-4xl mx-auto p-4 space-x-4">
                <div class="flex-1 bg-white shadow-md rounded-lg p-3 mt-6">
                    <div class="w-full max-w-sm flex justify-center flex-col items-center">
                        <p class="border-2 border-black bg-gray-100 text-center text-xl font-medium py-2 rounded-md shadow-md mt-4"
                           style="width:10rem">
                            {{ $date }}
                        </p>
                    </div>

                    @include('reservations.reservationUpdateChosenSlot')
                </div>
                <div class="flex-1 bg-white shadow-md rounded-lg p-4 max-h-[80vh] overflow-auto mt-6"
                     style="width: 40rem">
                    <h1 class="text-3xl font-bold mb-6 text-gray-900">Edit Reservation</h1>

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                            <strong class="font-bold">Error:</strong>
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    @if(session('success'))
                        <div
                            class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                            <strong class="font-bold">Success:</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @include('reservations.ReservationUpdateForm')
                    @if($status !== 'canceled')
                    @include('reservations.button-cancel')
                    @endif
                </div>
            </div>
            <a href="{{ route('reservation.show') }}"
               class="mt-1 inline-flex items-center px-4 py-2 text-base font-medium text-white rounded-full shadow-md hover:bg-gray-300 transition duration-300"
               style="flex-direction: column">
                <- Back to your reservations
            </a>

        </div>
    </section>
    <x-footer></x-footer>
</x-app-layout>
