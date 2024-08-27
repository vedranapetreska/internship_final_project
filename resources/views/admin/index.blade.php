<x-app-layout>
    @include('layouts.navigation')
    <section class="relative min-h-screen flex items-center justify-center bg-white" style="margin-top: 4rem">
        <div class="mt-4">
            <h1 class="text-3xl font-bold mb-6 text-gray-900">Reservations</h1>

            @include('admin.dates-status')

            @include('admin.reservations-table')
        </div>
    </section>
    <x-footer></x-footer>
</x-app-layout>
