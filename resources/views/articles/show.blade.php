@extends('layouts.app')

@section('head-style')
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN' crossorigin='anonymous'>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL' crossorigin='anonymous'></script>

    {{-- Add Tailwind Hero Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        img.banner {
            width: 100%;
            aspect-ratio: 16/3;
            object-fit: cover;

            transition: 0.3s ease-in-out;
        }

        @media (max-width: 768px) {
            img.banner {
                aspect-ratio: 16/9;
                transition: 0.3s ease-in-out;
            }
        }

        /* Tablet */
        @media (min-width: 768px) and (max-width: 1024px) {
            img.banner {
                aspect-ratio: 16/6;
                transition: 0.3s ease-in-out;
            }
        }

        .header .image-container {
            position: relative;
        }

        .header .image-container img {
            width: 100%;
            height: auto;
        }

        .header .button-container {
            position: absolute;
            bottom: 10px; /* Adjust as needed */
            left: 10px; /* Adjust as needed */
        }

        a.rounded-button{
            width: 48px;
            height: 48px;
            border-radius: 100%;
            background-color: #f8f9fa7b;
            display: flex;
            align-items: center;
            text-align: center;
            justify-content: center;
            text-decoration: none;
            color: #000;
            transition: 0.3s;
            font-size: 16pt;
        }
        a.rounded-button i {
            transform: translateX(-2px);
        }

        a.rounded-button:hover {
            background-color: #e9ecef;
        }

        .personalize-card {
            margin: 32pt 0;
        }

        p.price {
            font-size: 24pt;
            font-weight: bold;
            color: #000;
        }

        img.media-photo {
            /* make it ratio 11/10 */
            width: 100%;
            aspect-ratio: 11/10;
        }
    </style>

    {{-- Lightbox --}}
    @include('utils.lightbox')
@endsection

@section('content')
    <div class="header">
        <div class="image-container">
            <img src="{{ asset($article->getThumbnailUrlAttribute()) }}" alt="{{$article->title}}" 
                class="img-fluid banner"
                >

            {{-- Back button --}}
            <div class="button-container">
                <a href="{{ route('articles.index') }}" class="rounded-button">
                    <i class="bi bi-chevron-left"></i>
                </a>
            </div>
        </div>
    </div>
    
        
    <div class="container">
    
        <div class="row w-100 mb-4">
            <div class="col-md-8">
                {{-- Show Category and tags --}}
                <div class="d-flex flex-wrap my-2">
                    <span class="badge bg-primary mr-2">{{ $article->category->name }}</span>
                    @foreach ($article->tags as $tag)
                        <span class="badge bg-secondary mr-2">{{ $tag->name }}</span>
                    @endforeach
                </div>
        
                <h1>{{ $article->title }}</h1>

                {{-- Show date --}}
                <p class="text-muted mb-2"><i class="bi bi-clock mr-3"></i>{{ $article->created_at->diffForHumans() }}
                    @if($article->created_at != $article->updated_at), Edited {{$article->updated_at->diffForHumans()}}@endif
                </p>

                {{-- Show content --}}

                <p>{!! $article->content !!}</p>


                @if($article->address != null)
                    <h3>Lokasi</h3>

                    {{-- Open in google maps --}}
                    

                    <p>{{$article->address}}</p>

                    @if($article->google_maps_embed != null)
                        <iframe 
                            src="{{$article->google_maps_embed}}" 
                            width="max" 
                            height="450" 
                            style="border:0;" 
                            allowfullscreen="true" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade"
                            class="w-100"
                            >

                        </iframe>
                    @endif
                    @if($article->google_maps)
                        <a href="{{ $article->google_maps }}" target="_blank" class="btn btn-primary w-100">
                            <i class="bi bi-geo-alt mx-2"></i>Buka di Google Maps
                        </a>
                    @endif
                
                @endif
            </div>
        
            <div class="col-md-4">
                {{-- Card about the author --}}
                <div class="card personalize-card">
                    <div class="card-body">
                        <h5 class="card-title">Author</h5>
                        <p class="card-text">{{ $article->user->name }}</p>
                        <a href="{{route('management.articles.edit', $article)}}" class="btn btn-warning">
                            <i class="bi bi-pencil-square mx-2"></i>
                        </a>
                        <form action="{{route('management.articles.destroy', $article)}}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash mx-2"></i>
                            </button>
                        </form>

                        <p class="card-text mt-2">Untuk melakukan penawaran Anda dapat menghubungi kontak dibawah ini melalui Whatsapp.</p>

                        <div class="card-text">
                            {{-- Article Contact Whatsapp --}}
                            <a target="_blank" href="{{$article->getWhatsappLinkAttribute()}}" class="btn btn-success mb-2 w-100">
                                <i class="bi bi-whatsapp mx-2"></i>Hubungi narahubung {{ $article->whatsapp_name }}
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Harga Penawaran --}}
                <div class="card personalize-card mt-3">
                    <div class="card-body">
                        <h5 class="card-title">Penawaran</h5>
                        <p class="card-text">Berikut adalah informasi harga produk yang ditawarkan oleh pemilik</p>
                        <p class="card-text price">{{$article->getFormattedPriceAttribute()}}</p>
                        <i>per {{$article->unit}}</i>
                    </div>
                </div>
            </div>
        </div>

        <h3>Media Foto</h3>
        {{-- Show all photos related to this article --}}
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach ($article->images as $photo)
                <div class="col">
                    <a href="{{asset($photo->path)}}" 
                        data-lightbox="image-1" 
                        data-title="{{$photo->name}}"
                        >
                        <img 
                            src="{{asset($photo->path)}}" 
                            class="d-block w-100 media-photo"
                            alt="{{$photo->name}}">
                    </a>
                </div>
            @endforeach
        </div>

        <br>
        <br>

    </div>
    
@endsection