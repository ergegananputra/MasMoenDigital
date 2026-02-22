<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'MasMoenDigital') }}</title>
        <meta name="description" content="Masuk atau daftar ke MasMoenDigital untuk mempublikasikan produk dan iklan Anda.">
        <meta name="robots" content="noindex, nofollow">

        <link rel="icon" href="{{ asset('image/favicon.png') }}" type="image/x-icon">

        <!-- Open Graph -->
        <meta property="og:type" content="website">
        <meta property="og:title" content="{{ config('app.name', 'MasMoenDigital') }}">
        <meta property="og:description" content="Masuk atau daftar ke MasMoenDigital untuk mempublikasikan produk dan iklan Anda.">
        <meta property="og:image" content="{{ asset('image/favicon.png') }}">
        <meta property="og:site_name" content="MasMoenDigital">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body>
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>

        @livewireScripts
    </body>
</html>
