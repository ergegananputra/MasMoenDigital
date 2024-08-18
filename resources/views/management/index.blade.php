@extends('layouts.app')

@section('head-style')
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN' crossorigin='anonymous'>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL' crossorigin='anonymous'></script>

    {{-- Add Tailwind Hero Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .header {
            width: 100vw;
            height: 50vh;
            display: flex;
            align-items: flex-end;
        }

        .text-container {
            text-align: left;
            color: rgb(0, 0, 0);
            padding: 10vh;
        }

        .icons-button a {
            height: 56px;
            margin-top: 16px;
            display: flex;
            align-items: center;
            justify-content: end;
            width: auto;
            padding: 0 16px;
        }

        .icons-button a i {
            font-size: 16pt;
            margin-left: 8px;
        }

        .side-btn {
            width: auto;
            background-color: #f8f9fa;
            border-radius: 8px;
            color: #000;
            text-decoration: none;
            transition: 0.3s;
        }

        img.img-article{
            width: 100%;
            aspect-ratio: 11/10;
        }

    </style>
@endsection

@section('content')
    <div class="header">
        <div class="container">
            <div class="row w-100">
                <div class="text-container col-12 col-md-9">
                    <h1 class="text-4xl font-bold">Kelola Konten</h1>
                    <p class="text-lg">Selamat datang di halaman kelola konten. 
                        Laman ini merupakan tempat untuk mengelola konten yang ada di website.</p>
                </div>
            
                <div class="col-12 col-md-3 icons-button mt-3 mt-md-0 d-flex flex-column">
                    @auth
                        @if (Auth::user()->isAdmin())
                            <a href="{{route('management.tags.index')}}" class="btn side-btn d-flex align-items-center mb-2">
                                <p class="mb-0">Tambah Tag</p>
                                <i class="bi bi-tag"></i> 
                            </a>
                    
                            <a href="{{route('management.categories.index')}}" class="btn side-btn d-flex align-items-center mb-2">
                                <p class="mb-0">Tambah Kategori</p>
                                <i class="bi bi-archive"></i> 
                            </a>
                        @endif
                    @endauth
                    
            
                    <a href="{{route('management.articles.create')}}" class="btn side-btn d-flex align-items-center">
                        <p class="mb-0">Tambah Artikel</p>
                        <i class="bi bi-upload"></i> 
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <h2>Artikel</h2>

        {{-- Search & Filter --}}
        <form action="{{ route('management.index') }}" method="GET">
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
                @include('components.article_card', ['article' => $article, 'action' => true])
            @endforeach
        </div>
    </div>

    <br> <br>
@endsection