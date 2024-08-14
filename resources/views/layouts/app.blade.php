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
            .navigation-menu {
                position: fixed; /* or absolute, fixed, sticky */
                top: 0;
                left: 0;
                right: 0;
                z-index: 1000; /* Adjust the value as needed */
                height: auto; /* Ensure it does not cover the entire viewport */
            }

            .navigation-menu a{
                text-decoration: none;
            }
            .text-logo-nav {
                text-decoration: none;

                font-weight: bolder;
                background: linear-gradient(to right, #007BFF, #501bef);
                background-clip: text;
                -webkit-text-fill-color: transparent;
                font-size: 1.3rem;
                transition: all 0.6s ease;
            }
            a.card-clickable-body{
                text-decoration: none;
                color: rgb(29, 27, 27);
            }
            .img-container {
                width: 100%;
                aspect-ratio: 11/10;

                transition: 0.3s ease-in-out;

                /* clip */
                overflow: hidden;
                
                transition: 0.3s ease-in-out;
            }

            .img-container img {
                transition: 0.3s ease-in-out;
            }

            .img-container img:hover {
                transform: scale(1.2);
                transition: 0.3s ease-in-out;
            }

            .mmd-navbar {
                background-color: rgba(255, 255, 255, 0.8) !important; /* Semi-transparent background */
                backdrop-filter: blur(10px); /* Blur effect */
                -webkit-backdrop-filter: blur(10px); /* For Safari */
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Optional: Add a subtle shadow */
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
        @livewireScripts

        @stack('scripts')
    </body>

    <script>
        function copyLink(url) {
                // Create a temporary input element
                var tempInput = document.createElement('input');
                tempInput.value = url;
                document.body.appendChild(tempInput);
        
                // Select the input value
                tempInput.select();
                tempInput.setSelectionRange(0, 99999); // For mobile devices
        
                // Copy the text inside the input
                document.execCommand('copy');
        
                // Remove the temporary input element
                document.body.removeChild(tempInput);
        
                // Optionally, show a message to the user
                alert('Berhasil menyalin link!' + '\n' + url);
            }
        
    </script>
</html>
