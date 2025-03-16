<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Bookings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mt-3 mx-auto sm:px-6 lg:px-8">
            <livewire:booking-data>
        </div>
    </div>
</x-app-layout>
