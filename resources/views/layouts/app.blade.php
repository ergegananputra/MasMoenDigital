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

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @yield('head-style')

        <style>
            a.card-clickable-body{
                text-decoration: none;
                color: rgb(29, 27, 27);
            }
            img.img-article{
                width: 100%;
                aspect-ratio: 11/10;
            }
            .navigation-menu {
                position: fixed; /* or absolute, fixed, sticky */
                top: 0;
                left: 0;
                right: 0;
                z-index: 1000; /* Adjust the value as needed */
            }
        </style>
        
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen bg-gray-100">
            <div class="navigation-menu">
                @livewire('navigation-menu')
            </div>

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                @if (isset($slot))
                    {{ $slot }}
                @else
                    @yield('content')
                @endif
            </main>
        </div>

        @stack('modals')
        @stack('scripts')

        @livewireScripts
    </body>
</html>
