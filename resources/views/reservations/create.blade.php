@php use Carbon\Carbon; @endphp
<x-app-layout>
    @include('layouts.navigation')
    <section class="relative min-h-screen flex items-start bg-gray-400 pt-16">
        <div class="flex flex-row justify-between max-w-4xl mx-auto p-4 space-x-4">
            <div class="flex-1 bg-white shadow-md rounded-lg p-3">
                <div class="w-full max-w-sm" style="display: flex;justify-content: center;flex-direction: column;align-items:center ">

                    <p class="border-2 border-black bg-gray-100 text-center text-xl font-medium py-2 rounded-md shadow-md mt-4" style="width:10rem">
                        {{ $date }}
                    </p>
                </div>

                @include('reservations.reservationChosenSlot')


            </div>

            <div class="flex-1 bg-white shadow-md rounded-lg p-4 max-h-[80vh] overflow-auto" style="width: 40rem">
                <h1 class="text-2xl font-bold mb-4 text-gray-900">Make a Reservation</h1>

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded relative mb-4">
                        <strong class="font-bold">Error:</strong>
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded relative mb-4">
                        <strong class="font-bold">Success:</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @include('reservations.reservationForm')
            </div>
        </div>
    </section>

    <x-footer></x-footer>
</x-app-layout>
