<x-app-layout>
    <!-- Page Content -->
    <div class="min-h-screen bg-gray-100">
        <!-- Standard Navigation -->
        @include('layouts.navigation')

        <!-- Services Section with Background Image -->
        <x-services backgroundImage="{{ asset('images/image1.jpg') }}">
            <!-- Welcome Message -->
            <span class="block text-white text-4xl font-bold">Welcome to</span>
            <span class="block text-white text-4xl font-bold">Tennis Club Prilep {{ Auth::user()->name }}</span>
        </x-services>

        <!-- Footer -->
        <x-footer></x-footer>
    </div>
</x-app-layout>
