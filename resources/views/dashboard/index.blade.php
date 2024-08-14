@extends('layouts.app')

@section('head-style')
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN' crossorigin='anonymous'>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL' crossorigin='anonymous'></script>

    {{-- Add Tailwind Hero Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .safezone {
            padding-top: 15vh;
            padding-bottom: 15vh;
        }

        .header {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 70vh; /* Full viewport height */

            margin-bottom: 15vh;
        }

        .frosted-glass {
            background-color: rgba(255, 255, 255, 0.8) !important; /* Semi-transparent background */
            backdrop-filter: blur(10px); /* Blur effect */
            border-radius: 36pt;
        }

        p.text-body-header {
            font-size: 1.2rem;
            text-align: center;
            color: rgb(0, 0, 0);
        }

        .header:hover h1.text-header {
            transform: scale(1.05) translateY(-5%);
            transition: all 0.6s ease;
        }


        h1.text-header {
            font-weight: bolder;
            background: linear-gradient(to right, #007BFF, #501bef);
            background-clip: text;
            -webkit-text-fill-color: transparent;
            transition: all 0.6s ease;
        }

        h1.text-header span.header-black {
            background: linear-gradient(to right, #656565, #423e4c);
            background-clip: text;
            font-size: 80%;
        }

        .clock {
            text-align: center;
            font-weight: bolder;
            color: linear-gradient(to right, #656565, #423e4c);
            padding: 10px; /* Add some padding for better appearance */
            border-radius: 14px; /* Optional: Add rounded corners */
            margin: 5vh 0 2vh;

            transition: all 0.6s;
        }

        .clock-item {
            width: 2em;
            padding: 10px; /* Add padding to create gutter between items */
            background-color: rgba(255, 255, 255, 0.8) !important; /* Semi-transparent background */
            backdrop-filter: blur(10px); /* Blur effect */
            border-radius: 8px; /* Optional: Add rounded corners to clock items */
            margin: 6px; /* Add margin to create gutter between items */
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.8); /* Add glow effect */

            transition: all 0.6s;
        }

        .btn-register {
            background: linear-gradient(30deg, #007BFF, #501bef);
            color: white;
            border: none;
            
            transition: 0.6s;
        }

        .btn-register:hover {
            filter: grayscale(70%);
            /* drop shadow */
            box-shadow: 0 0 10px rgba(53, 83, 170, 0.5);
            transition: all 0.6s;
        }

        .btn-login {
            background-color: transparent; /* Remove background color */
            color: #501bef; /* Set text color to the desired color */
            border: 2px solid #501bef; /* Add border with the desired color */
            
            transition: 0.6s;
        }

        .mmd-button {
            text-decoration: none;
            min-width: 150px;
            padding: 8px 16px;
            border-radius: 8px;
            margin: 10px;

            display: flex; /* Use flexbox */
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */

            transition: 0.6s;
        }

    </style>
@endsection

@section('content')
    <div class="container safezone">
       
        <div class="header d-flex flex-column align-items-center">
            <h1 class="display-1 text-header">MasMoenDigital<span class="header-black">.store</span></h1>
            <p class="text-body-header my-2">
                Selamat datang di MasMoenDigital, website ini merupakan website yang didirikan untuk memberikan kemudahan bagi 
                usaha menengah dalam mempublikasikan produk-produknya maupun iklan yang ingin disampaikan. Selain itu website ini juga dapat dijadikan
                sebagai platform media informasi bagi masyarakat umum.
            </p>

            <div class="d-flex justify-content-center align-items-center">
                <div id="clock" class="clock display-1 d-flex flex-row g-3">
                    <div class="clock-item" id="clock-hours"></div>
                    <div class="clock-item" id="clock-minutes"></div>
                    <div class="clock-item" id="clock-seconds"></div>
                </div>
            </div>

            @auth
                <a href="#artikel-terkini" class="btn btn-login mmd-button">Jelajahi Sekarang!</a>
            @else
                <p class="text-body-header mt-4"><b>Ingin menjadi bagian dari kami?</b> <br>Tunggu apa lagi daftarkan dirimu sekarang juga!</p>

                <div class="d-flex flex-row g-4">
                    <a href="{{ route('login') }}" class="btn btn-login mmd-button">Masuk</a>
                    <a href="{{ route('register') }}" class="btn-register mmd-button">Daftar</a>
                </div>
            @endauth

            
            
        </div>

        
        <h2 id="artikel-terkini">Artikel Terkini</h2>

        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach ($latestArticles as $article)
                @include('components.article_card', ['article' => $article])
            @endforeach
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        function updateClock() {
            const now = new Date();
            const hours = document.getElementById('clock-hours');
            const minutes = document.getElementById('clock-minutes');
            const seconds = document.getElementById('clock-seconds');
            // clock.innerText = now.toLocaleString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric' });
            hours.innerText = now.toLocaleString('id-ID', {hour: 'numeric'});
            minutes.innerText = now.toLocaleString('id-ID', {minute: 'numeric'});
            seconds.innerText = now.toLocaleString('id-ID', {second: 'numeric'});
        }

        setInterval(updateClock, 1000);
    </script>
@endpush