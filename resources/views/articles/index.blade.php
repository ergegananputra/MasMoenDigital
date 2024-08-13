@extends('layouts.app')

@section('head-style')
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN' crossorigin='anonymous'>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL' crossorigin='anonymous'></script>

    {{-- Add Tailwind Hero Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .safezone {
            padding: 10vh 0vw;
        }

        .text-container {
            text-align: left;
            color: rgb(0, 0, 0);
            padding: 10vh;
        }

        span.text-logo-welcome {
            font-weight: bold;
            background: linear-gradient(to right, #007BFF, #501bef);
            background-clip: text;
            -webkit-text-fill-color: transparent;
            transition: all 0.6s ease;
        }

        .glow-background {
            background: linear-gradient(135deg, rgba(0, 123, 255, 0.03), rgba(80, 27, 239, 0.03));
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.5), 0 0 20px rgba(0, 123, 255, 0.5), 0 0 30px rgba(0, 123, 255, 0.5);
            transition: box-shadow 0.6s ease;
        }
    </style>
@endsection

@section('content')
    <div class="safezone">
        <div class="container">

            <div class="text-container col-12 col-md-9">
                <h1 class="text-4xl font-bold">Artikel</h1>
                <p class="text-lg">Selamat datang di artikel <span class="text-logo-welcome">Mas Moen Digital</span>. 
                    Platform ini merupakan tempat berbagi informasi mengenai artikel umum, iklan, dan lainnya.
                    Jadilah bagian dari kami dengan memberikan informasi yang bermanfaat bagi semua orang.
                    Daftarkan diri Anda sekarang juga!
                </p>

            </div>

            {{-- Search & Filter --}}
            <form action="{{ route('articles.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-3">
                        <select class="form-select" name="category">
                            <option value="">Pilih Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-9">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari artikel" name="search" value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
                        </div>
                    </div>
                </div>
            </form>

            <p class="mt-3"><i>Sebanyak {{ $articles->total() }} artikel ditemukan</i></p>
              
            
        
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach ($articles as $article)
                    @include('components.article_card', ['article' => $article])
                @endforeach
            </div>

            {{-- Pagination links --}}
            <div class="row">
                <div class="col-md-12">
                    {{ $articles->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection