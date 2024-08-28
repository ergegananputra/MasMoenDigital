<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - @yield('title', "All in one solutions!")</title>
        <meta name="description" content="@yield('description', 'Selamat datang di MasMoenDigital, website ini merupakan website yang didirikan untuk memberikan kemudahan bagi 
                usaha menengah dalam mempublikasikan produk-produknya maupun iklan yang ingin disampaikan. Selain itu website ini juga dapat dijadikan
                sebagai platform media informasi bagi masyarakat umum.')">

        <link rel="icon" href="{{asset('image/favicon.png')}}" type="image/x-icon">

        <meta name="google-site-verification" content="__rQbpZqcQNaStkWi3BWLuTNpiKtd0T-C9aUql_f51w" />

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
                z-index: 500; /* Adjust the value as needed */
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
            

            .mmd-navbar {
                background-color: rgba(255, 255, 255, 0.8) !important; /* Semi-transparent background */
                backdrop-filter: blur(10px); /* Blur effect */
                -webkit-backdrop-filter: blur(10px); /* For Safari */
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Optional: Add a subtle shadow */
            }

            .footer {
                background: linear-gradient(to right, #007BFF, #501bef);
                color: white;
            }

            

        </style>

        @include('utils.card-article-style')
        @include('utils.content-rich-style')
        
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

    <footer class="footer">
        <div class="container">
            <div class="row">
            <div class="col-sm-6 col-md-6 mt-4 col-lg-4 text-center text-sm-start">
              <h5 class="footer-heading text-uppercase text-white fw-bold">Mas Moen Digital</h5>
              <p>Hubungi kami jika memerlukan bantuan atau ingin berkolaborasi dengan kami.</p>
            </div>
                <div class="col-sm-6 col-md-6 mt-4 col-lg-4 text-center text-sm-start">
                  <div class="contact">
                      <h6 class="footer-heading text-uppercase text-white fw-bold">Hubungi</h6>
                      <a target="_blank" href="mailto:helpdesk@masmoendigital.store" class="text-white mb-1 text-decoration-none d-block fw-semibold"><i class="bi bi-envelope"></i> helpdesk@masmoendigital.store</a>
                  </div>
                </div>
            </div>
        </div>
        <div class="text-center bg-dark text-white mt-4 p-1">
            <p class="mb-0 fw-bold">2024 © MasMoenDigital, All Rights Reserved</p>
        </div>
    </footer>


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
