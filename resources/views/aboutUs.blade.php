<x-app-layout>
    @include('layouts.navigation')
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            About Us
        </h2>
    </x-slot>

    <div class="container mx-auto my-8 p-6 bg-white rounded-lg shadow-md">
        <section class="mb-8">
            <h2 class="text-2xl font-semibold mb-4">Our Mission</h2>
            <p class="text-gray-700">
                At our Tennis Club, we are dedicated to fostering a love for the game by providing top-quality facilities and a seamless reservation experience. Our mission is to make tennis accessible to everyone, whether you're a seasoned player or just starting out. We strive to create an environment where members can improve their skills, enjoy friendly competition, and be part of a vibrant tennis community. Through our state-of-the-art court reservation system, we aim to offer convenience, flexibility, and exceptional service to enhance your tennis experience.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-semibold mb-4">Activities</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-gray-100 p-4 rounded-lg shadow-md">
                    <img src="{{ asset('images/tennis1.jpg') }}" alt="" class="w-full h-60 object-cover rounded-t-lg mb-4">
                </div>

                <div class="bg-gray-100 p-4 rounded-lg shadow-md">
                    <img src="{{ asset('images/tennis2.jpg') }}" alt="" class="w-full h-60 object-cover rounded-t-lg mb-4">
                </div>

                <div class="bg-gray-100 p-4 rounded-lg shadow-md">
                    <img src="{{ asset('images/tennis4.jpg') }}" alt="" class="w-full h-60 object-cover rounded-t-lg mb-4">
                </div>
            </div>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-semibold mb-4">Court Reservation Pricing</h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
                    <thead>
                    <tr>
                        <th class="py-2 px-4 bg-gray-100 text-left text-gray-600 font-medium">Duration</th>
                        <th class="py-2 px-5 bg-gray-100 text-left text-gray-600 font-medium">Price</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="py-2 px-4 border-b border-gray-200">1 hour</td>
                        <td class="py-2 px-4 border-b border-gray-200">300 MKD</td>
                    </tr>
                    <tr>
                        <td class="py-2 px-4 border-b border-gray-200">1 hour 30 minutes</td>
                        <td class="py-2 px-4 border-b border-gray-200">400 MKD</td>
                    </tr>
                    <tr>
                        <td class="py-2 px-4 border-b border-gray-200">2 hours</td>
                        <td class="py-2 px-4 border-b border-gray-200">500 MKD</td>
                    </tr>
                    </tbody>
                </table>

                <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
                    <thead>
                    <tr>
                        <th class="py-2 px-4 bg-gray-100 text-left text-gray-600 font-medium">Duration</th>
                        <th class="py-2 px-1 bg-gray-100 text-left text-gray-600 font-medium">Price (Night)</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="py-2 px-4 border-b border-gray-200">1 hour</td>
                        <td class="py-2 px-4 border-b border-gray-200">400 MKD</td>
                    </tr>
                    <tr>
                        <td class="py-2 px-4 border-b border-gray-200">1 hour 30 minutes</td>
                        <td class="py-2 px-4 border-b border-gray-200">600 MKD</td>
                    </tr>
                    <tr>
                        <td class="py-2 px-4 border-b border-gray-200">2 hours</td>
                        <td class="py-2 px-4 border-b border-gray-200">800 MKD</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <x-footer></x-footer>
</x-app-layout>
