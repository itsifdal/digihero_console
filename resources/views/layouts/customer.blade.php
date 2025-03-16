<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
        
        <!-- FullCalendar CSS -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.5/main.min.css" rel="stylesheet">
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            <div>
                <a href="/" wire:navigate>
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <!-- Page Content -->
            <div class="w-full mx-auto">
                {{ $slot }}
            </div>

        </div>

        <!-- FullCalendar JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.5/main.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@5.11.5/main.min.js"></script>

    </body>
</html>
