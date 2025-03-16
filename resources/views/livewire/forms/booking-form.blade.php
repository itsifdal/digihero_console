
<?php

use Livewire\Component;
use Livewire\Attributes\On;

new class extends Component
{
    #[On('snapTokenGenerated')] 

    public $snapToken;

}; ?>

<div>
    <div class="mt-16">

        <div id="snap-container"></div>

        @if($step == 1)
        <!-- Step 1: Console Options -->
        <div>
            <header>
                <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                    {{ __('Step 1 - Select Console') }}
                </h2>
            </header>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                @foreach($services as $service)
                <div class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                    <div>
                        <!-- <div class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-7 h-7 stroke-red-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                            </svg>
                        </div> -->

                        <div class="flex justify-between">
                            <div class="flex flex-row items-center gap-4">
                                <label class="inline-flex items-center">
                                    <input 
                                        wire:model="service_id" 
                                        wire:change="selectServiceId('{{ $service->uuid }}')"
                                        name="service_id"
                                        type="radio" 
                                        value="{{ $service->uuid }}" 
                                        required>
                                </label>
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $service->name }}</h2>
                            </div>
                        </div>

                        <p class="mt-4 text-gray-500 dark:text-yellow-400 text-md font-semibold leading-relaxed ml-8">
                            Rp{{ number_format($service->price) }} / Sesi
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Step 2: Interactif Calendar View -->
        <header class="mt-8">
            <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                {{ __('Step 2 - Pick Date') }}
            </h2>
        </header>
        <div class="grid grid-cols-1 md:grid-cols-1 gap-4 mt-4">
            <div class="border-t flex-grow"></div>
            @if(session()->has('message'))
                <div class="bg-green-500 text-white p-2 rounded mt-4">
                    {{ session('message') }}
                </div>
            @endif

            <div id="calendar" wire:ignore></div>

            <div class="flex justify-between items-center mt-4">
                <x-input-label :value="__('Notes')" class="text-gray-900 dark:text-white" />
                <div class="flex flex-row items-center gap-4">
                    <p class="text-yellow-500 font-bold text-ml">
                     Charge for weekend  (Saturday and Sunday) Rp50.000
                    </p>
                </div>
            </div>
            <div class="mt-6 flex justify-between">
                <x-primary-button wire:click="prevStep()"> {{ __('Previous') }} </x-primary-button>
                <x-secondary-button wire:click="nextStep()"> {{ __('Next') }} </x-secondary-button>
            </div>
        </div>
        @endif
        
        @if($step == 2)
        <!-- Step 2: Review Options -->
        <header class="mt-8">
            <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                {{ __('Step 3 - Review') }}
            </h2>
        </header>
        <div id="calendar" wire:ignore></div>
        <div class="grid grid-cols-1 md:grid-cols-1 gap-4 mt-4">
            <div class="border-t flex-grow"></div>
            <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                Nama Service yang Dipilih 
            </h2>
            <div class="flex justify-between items-center mt-4">
                <x-input-label :value="__('Total')" class="text-gray-900 dark:text-white" />
                <div class="flex flex-row items-center gap-4">
                    <p class="text-yellow-500 font-bold text-ml">
                        Rp{{ number_format($normal_price) }}
                    </p>
                </div>
            </div>
            <div class="flex justify-between items-center mt-4">
                <x-input-label :value="__('Selected Date & Time')" class="text-gray-900 dark:text-white" />
                <div class="flex flex-row items-center gap-4">
                    <p class="text-yellow-500 font-bold text-ml">
                        {{ $selectedDate }}
                    </p>
                </div>
            </div>
            <!-- Jika Weekend -->
            @if($isCharged)
            <div class="flex justify-between items-center mt-4">
                <x-input-label :value="__('Charge Weekend')" class="text-gray-900 dark:text-white" />
                <div class="flex flex-row items-center gap-4">
                    <p class="text-yellow-500 font-bold text-ml">
                       Rp{{ number_format($weekendCharge) }} 
                    </p>
                </div>
            </div>
            @endif
            <div class="flex justify-between items-center mt-4">
                <x-input-label :value="__('Grand Total')" class="text-gray-900 dark:text-white" />
                <div class="flex flex-row items-center gap-4">
                    <p class="text-yellow-500 font-bold text-ml">
                        Rp{{ number_format($total_price) }}
                    </p>
                </div>
            </div>
            <!-- Personal Information -->
            <form wire:submit.prevent="processPayment" class="mt-6 space-y-6" novalidate>
                <!-- PIC -->
                <div>
                    <x-input-label for="customer_name" :value="__('Nama Lengkap')" class="text-gray-900 dark:text-gray-100"/>
                    <x-text-input wire:model="customer_name" id="pic_name" name="customer_name" type="text" class="mt-1 block w-full" required autofocus/>
                    <x-input-error class="mt-2" :messages="$errors->get('customer_name')" />
                </div>

                <div>
                    <x-input-label for="whatsapp_number" :value="__('No Whatsapp')" class="text-gray-900 dark:text-gray-100"/>
                    <x-text-input wire:model="whatsapp_number" id="whatsapp_number" name="whatsapp_number" type="number" class="mt-1 block w-full" required autofocus/>
                    <x-input-error class="mt-2" :messages="$errors->get('whatsapp_number')" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Email (Opsional)')" class="text-gray-900 dark:text-gray-100"/>
                    <x-text-input wire:model="email" id="email" name="email" type="email" class="mt-1 block w-full" required autofocus/>
                </div>
            </form>
            <div class="border-t flex-grow"></div>
            <div class="mt-6 flex justify-between">
                <x-primary-button wire:click="prevStep()"> {{ __('Previous') }} </x-primary-button>
                <x-secondary-button wire:click="processPayment"> {{ __('Pay Now') }} </x-secondary-button>
            </div>
        </div>

            @if (session()->has('success'))
                <div class="bg-green-500 text-white p-2 rounded mt-4">
                    {{ session('success') }}
                </div>
            @endif
            @if (session()->has('error'))
                <div class="bg-red-500 text-white p-2 rounded mt-4">
                    {{ session('error') }}
                </div>
            @endif

        @endif
        
    </div>

    <script>
        function payWithSnap(snapToken) {

            window.snap.pay(snapToken[0], {
                onSuccess: function (result) { 
                    // console.log("Payment Success:", result); 
                },
                onPending: function (result) { 
                    // console.log("Payment Pending:", result); 
                },
                onError: function (result) { 
                    // console.error("Payment Error:", result); 
                },
                onClose: function () { 
                    // console.warn("Payment Closed by User!"); 
                }
            });

        }

        document.addEventListener("DOMContentLoaded", function() {
            if (typeof Livewire === 'undefined') {
                console.error("Livewire not loaded!");
                return;
            }

            Livewire.on('midtransTokenGenerated', snapToken => {
                payWithSnap(snapToken);
            });
        });
    </script>

    <script type="module">
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar   = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                selectable: true,
                dateClick: function(info) {
                    Livewire.dispatch('dateClicked', { date: info.dateStr });
                }
            });
            calendar.render();
        });
    </script>

    
</div>
