@extends('layouts.app')

@section('head-style')
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN' crossorigin='anonymous'>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL' crossorigin='anonymous'></script>

    {{-- Add Tailwind Hero Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .card-form {
            margin: 24px auto;
            padding: 16px 32px;
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent background */
            backdrop-filter: blur(10px); /* Apply blur effect */
            -webkit-backdrop-filter: blur(10px); /* For Safari */
            border-radius: 10px; /* Rounded corners */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Optional: Add a subtle shadow */
        }

        .card-form .item {
            margin: 12px 0;
        }

        a.rounded-button{
            width: 48px;
            height: 48px;
            border-radius: 100%;
            background-color: #f8f9fa;
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

        .card-add-image{
            height: 200px;
            border: 2px dashed #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            color: #ccc;
            text-decoration: none;
            transition: 0.3s;
        }

        .blurred-background {
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;

            filter: blur(60px);
            -webkit-filter: blur(60px);

            height: 100vh;
            width: 100vw;

            position: fixed;

            z-index: 0;

            transition: 0.3s ease-in-out;

            background-color: #f3f4f6;

            transform: scale(2);
        }

        .blurred-background::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            height: 100vh;
            width: 100vw;
            background-color: #fcfcfc30; /* Adjust the opacity as needed */
            z-index: 1; /* Ensure the overlay is above the blurred background */
        }

        .content-section {
            z-index: 1;
            width: 100vw;
            top: max(5vh, 50pt);
            position: absolute;
        }



        .select2-container {
            width: 100% !important;
        }

        .select2-container--default .select2-selection--multiple {
            width: 100% !important;
            min-height: 50px; /* Adjust the height as needed */
        }

    </style>

    <!-- Include Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Include jQuery (required by Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include Select2 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{-- Summernote --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">

@endsection

@section('content')

<div class="blurred-background" id="form-background">asda</div>

<div class="content-section">
    <div class="container">
        <div class="card card-form">

            {{-- Back Icon Button --}}
            <a href="{{ route('articles.index') }}" class="rounded-button">
                <i class="bi bi-chevron-left"></i>
            </a>

            @isset($isEdit)
                <h1 class="text-4xl font-bold my-3">Edit Artikel</h1>

                <div class="alert alert-warning mt-4" role="alert"> <i class="bi bi-exclamation-circle"> </i>
                    Merubah judul artikel akan merubah URL artikel. Pastikan untuk memperbarui URL artikel di sumber lain jika diperlukan
                </div>
            @else
                <h1 class="text-4xl font-bold my-3">Tambah Artikel</h1>
            @endisset

            <form 
                @isset($isEdit)
                    action="{{route('management.articles.update', $article)}}" 
                @else
                    action="{{route('management.articles.store')}}" 
                @endisset
                method="post" enctype="multipart/form-data">
                @csrf

                @isset($isEdit)
                    @method('PUT')
                @endisset

                <h3>Informasi Umum</h3>

                {{-- Thumbnail --}}
                <div class="form-group row align-items-center item">
                    <label class="col-md-2 col-for-label" for="thumbnail">Thumbnail</label>
                    <div class="col-md-10">
                        @isset($article)
                            <div class="mb-2">
                                <p>Thumbnail: {{ basename($article->thumbnail_path) }}</p>
                            </div>
                        @endisset
                        <input type="file" name="thumbnail" id="thumbnail" class="form-control" onchange="previewThumbnail(event)">
                        <div id="thumbnail_preview" class="mt-3">
                            <!-- Image preview will be inserted here -->
                        </div>
                    </div>
                </div>
                
                <script type="text/javascript">
                    function previewThumbnail(event) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            var previewDiv = document.getElementById('thumbnail_preview');
                            previewDiv.innerHTML = ''; // Clear any existing content
                            var img = document.createElement('img');
                            img.src = e.target.result;
                            img.className = 'img-thumbnail';
                            img.style.width = '50%'; // Adjust as needed
                            img.style.height = 'auto';

                            // style to cover
                            img.style.objectFit = 'cover';

                            img.onload = function() {
                                var width = img.width;
                                var height = (width * 11) / 10;
                                img.style.height = height + 'px';
                            };

                            previewDiv.appendChild(img);

                            var formBackgroundDiv = document.getElementById('form-background');
                            formBackgroundDiv.style.backgroundImage = 'url(' + e.target.result + ')';
                        }
                        reader.readAsDataURL(event.target.files[0]);
                    }

                    document.addEventListener('DOMContentLoaded', function() {
                        @isset($article)
                            var previewDiv = document.getElementById('thumbnail_preview');
                            previewDiv.innerHTML = ''; // Clear any existing content
                            var img = document.createElement('img');
                            img.src = '{{ asset($article->thumbnail_path) }}';
                            img.className = 'img-thumbnail';
                            img.style.width = '50%'; // Adjust as needed
                            img.style.height = 'auto';

                            // style to cover
                            img.style.objectFit = 'cover';

                            img.onload = function() {
                                var width = img.width;
                                var height = (width * 11) / 10;
                                img.style.height = height + 'px';
                            };

                            previewDiv.appendChild(img);

                            var formBackgroundDiv = document.getElementById('form-background');
                            formBackgroundDiv.style.backgroundImage = 'url({{ asset($article->thumbnail_path) }})';
                        @endif
                    });
                </script>

                {{-- Title --}}
                <div class="form-group row align-items-center item">
                    <label class="col-md-2 col-for-label" for="title">Judul</label>
                    <div class="col-md-10">
                        <input type="text" name="title" id="title" class="form-control"
                            placeholder="Tulis judul artikel disini.."
                            @isset($article)
                                value="{{ $article->title }}"
                            @endisset
                            required
                            >
                    </div>
                </div>

                {{-- Category --}}
                <div class="form-group row align-items-center item">
                    <label class="col-md-2 col-for-label" for="category">Kategori</label>
                    <div class="col-md-10">
                        <select name="category" id="category" class="form-control" required>
                            <option value="">Pilih Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    @isset($article)
                                        @if ($article->category_id == $category->id)
                                            selected
                                        @endif
                                    @endisset
                                    >{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- WhatsappName --}}
                <div class="form-group row align-items-center item">
                    <label class="col-md-2 col-for-label" for="whatsapp_name">Nama Kontak</label> 
                    <div class="col-md-10">
                        <input type="text" name="whatsapp_name" id="whatsapp_name" class="form-control"
                            placeholder="Tulis nama kontak disini.."
                            @isset($article)
                                value="{{ $article->whatsapp_name }}"
                            @endisset
                            >
                    </div>
                </div>

                {{-- WhatsappNumber --}}
                <div class="form-group row align-items-center item">
                    <label class="col-md-2 col-for-label" for="whatsapp_number">Nomor Whatsapp</label>
                    <div class="col-md-10">
                        <input type="tel" name="whatsapp_number" id="whatsapp_number" class="form-control"
                            placeholder="contoh: 62812345678"
                            @isset($article)
                                value="{{ $article->whatsapp_number }}"
                            @endisset
                            pattern="[0-9]{10,15}"
                            >
                    </div>
                </div>

                <div class="form-group row align-items-center item">
                    <label class="col-md-2 col-for-label" for="price">Harga</label>
                    <div class="col-md-10">
                        <div class="input-group">
                            <input type="number" name="price" id="price" class="form-control"
                                placeholder="contoh: 1000000"
                                @isset($article)
                                    value="{{ $article->price }}"
                                @endisset
                                min="0"
                                >
                            <span class="input-group-text">per</span>
                            <input type="text" name="unit" id="unit" class="form-control"
                                placeholder="contoh: unit"
                                @isset($article)
                                    value="{{ $article->unit }}"
                                @endisset
                                >
                        </div>
                    </div>
                </div>
                

                {{-- Content --}}
                <div class="form-group col-md-12 item row content-rich">
                    <label for="content">Konten</label>
                    <div class="col-md-12">
                        <textarea name="content" id="content" class="form-control"
                            >@isset($article){{ $article->content }}@endisset</textarea>
                    </div>
                </div>

                <br>
                <br>

                <h3>Lokasi</h3>

                {{-- Address --}}
                <div class="form-group col-md-12 item row">
                    <label class="col-md-2 col-for-label" for="address">Alamat</label>
                    <div class="col-md-12">
                        <textarea name="address" id="address" class="form-control"
                        >@isset($article){{ $article->address }}@endisset</textarea>
                    </div>
                </div>

                {{-- Google Maps --}}
                <div class="form-group row align-items-center item">
                    <label class="col-md-2 col-for-label" for="google_maps">Google Maps</label>
                    <div class="col-md-10">
                        <input type="url" name="google_maps" id="google_maps" class="form-control"
                            placeholder="Tulis link Google Maps disini.."
                            value= @isset($article)
                                {{$article->google_maps}}
                            @endisset
                            >
                    </div>
                </div>

                {{-- Google Maps Embeded --}}
                <div class="form-group row align-items-center item">
                    <label class="col-md-2 col-for-label" for="google_maps_embeded">Google Maps Embeded</label>
                    <div class="col-md-10">
                        <input type="text" name="google_maps_embeded" id="google_maps_embeded" class="form-control"
                            placeholder="Tulis link Google Maps Embeded disini.."
                            value= @isset($article)
                                {{$article->google_maps_embed}}
                            @endisset
                            >
                    </div>
                </div>

                <br>
                <br>

                <h3>Media</h3>

                {{-- Image --}}
                <div class="form-group col-md-12 item">
                    <a href="javascript:void(0);" id="tambah" onclick="addFileInput()" 
                        class="btn card-add-image col">
                        <i class="bi bi-image"></i>
                        <p>Tambah Foto Anda disini! Pastikan foto yang Anda upload tidak lebih dari 2 MB dan memiliki rasio 1:1 untuk hasil yang maksimal
                        </p>
                    </a>
            
    
                    <div class="row row-cols-1 row-cols-md-3 g-3" id="fileinput_wrapper">
                        <!-- File input goes here -->
                    </div>

                    {{-- Show Photos --}}
                    @isset($article)

                        {{-- Warning sign if delete this, the form may not be saved --}}
                        <div class="alert alert-warning mt-4" role="alert"> <i class="bi bi-exclamation-circle"></i>
                            Jika Anda ingin menghapus foto yang telah diunggah sebelumnya, pastikan untuk menyimpan artikel terlebih dahulu. Aksi penghapusan akan mereset form
                        </div>

                        <div class="row row-cols-1 row-cols-md-3 g-3">
                            <script type="text/javascript">
                                function deleteImage(event, photoID) {
                                    event.preventDefault();
                                    var routeTemplate = `{{ route('management.articles.photos.destroy', ['article' => $article, 'photo_id' => 'PHOTO_ID_PLACEHOLDER']) }}`;
                                    var route = routeTemplate.replace('PHOTO_ID_PLACEHOLDER', photoID);
                                    var confirmation = confirm('Apakah anda ingin menghapus foto ini?');
                                    if (confirmation) {
                                        var form = document.getElementById('deletePhoto');
                                        form.action = route;
                                        form.submit();
            
                                        var container = document.getElementById('photo_item_'+photoID);
                                        container.remove();
                                    }
                                }
                            </script>
                            @foreach ($article->images as $photo)
                                <div class="rounded-full"
                                    style="margin-bottom: 5px;"
                                    id="photo_item_{{$photo->id}}"
                                    >
                                    <button class="btn btn-danger w-100" style="top: 5px; right: 5px;"
                                        onclick="deleteImage(event, {{$photo->id}})"
                                        ><i class="bi bi-trash"></i> Hapus
                                    </button>
                                    <img 
                                        src="{{ asset($photo->path) }}" 
                                        class="rounded-full img-thumbnail mx-auto d-block gallery_item"
                                        >
                                </div>
                                
                            @endforeach
                        </div>
                    @endisset
    
                    
                    
                    <script type="text/javascript">
                        function addFileInput () {
                            var div = document.getElementById('fileinput_wrapper');
                            var parentWidth = div.offsetWidth;

                            var card = document.createElement('div');
                            card.className = 'rounded-full';
                            card.style.marginBottom = '5px';
                            card.width = parentWidth / 3;
    
                            var fileInput = document.createElement('input');
                            fileInput.type = 'file';
                            fileInput.name = 'photos[]';
                            fileInput.id = 'photos';
                            fileInput.className = 'form-control';
                            fileInput.onchange = function (event) {
                                var reader = new FileReader();
                                reader.onload = function(e) {
                                    var img = document.createElement('img');
                                    img.src = e.target.result;
                                    img.className = 'rounded-full img-thumbnail mx-auto d-block gallery_item';
                                    img.width = parentWidth / 3;
                                    card.appendChild(img);
                                }
                                reader.readAsDataURL(event.target.files[0]);
                            };
                            card.appendChild(fileInput);

                            var deleteButton = document.createElement('button');
                            deleteButton.innerHTML = '<i class="bi bi-trash"></i> Hapus';
                            deleteButton.className = 'btn btn-danger';
                            deleteButton.style.top = '5px';
                            deleteButton.style.right = '5px';
                            deleteButton.style.width = '100%';
                            deleteButton.onclick = function () {
                                div.removeChild(card);
                            };

                            card.appendChild(deleteButton);

                            div.insertBefore(card, div.firstChild);

                            fileInput.click();
                        };
                    </script>
                </div>

                <br>
                <br>

                <h3>Informasi Tambahan</h3>

                {{-- Tags --}}
                <div class="form-group col-md-12 item">
                    <label for="tags">Tags</label>
                    <select name="tags[]" id="tags" class="form-control w-100" multiple>
                        @foreach ($tags as $tag)
                            @isset($article)
                                <option value="{{ $tag->id }}" {{ $article->tags->contains($tag->id) ? 'selected' : '' }}>
                                    {{ $tag->name }}
                                </option>
                            @else
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endisset
                            
                        @endforeach
                    </select>
                </div>

                <br>
                <br>
                
                {{-- Submit --}}
                <button type="submit" class="btn btn-primary item w-100" id="submit-button">
                    <i class="bi bi-plus-lg mx-2"></i>
                    @isset($article)Simpan @else Unggah @endisset Artikel
                </button>

                

            </form>
        </div>
    </div>

    <form id="deletePhoto" action="" method="post" style="display:none">
        @csrf
    </form>

    <script>
        $(document).ready(function() {
            $('#tags').select2({
                tags: true,
                tokenSeparators: [',', ' ']
            });
        });
    </script>

    @if ($errors->any())
    <div id="error-popup" style="display: none;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <script>
    window.addEventListener('load', function() {
        @if ($errors->any())
            alert("There are errors in the form:\n\n{{ implode('\n', $errors->all()) }}");
        @endif
    });
    </script>

</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>

<script>
    $(document).ready(function() {
        $('#content').summernote({
            height: 500,
            minHeight: 500,
            maxHeight: null,
            focus: true,
            callbacks: {
                onImageUpload: function(files) {
                    var $editor = $(this);
                    var data = new FormData();
                    data.append('file', files[0]);
                    $.ajax({
                        url: '{{ route('summernote.upload') }}',
                        method: 'POST',
                        data: data,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            $editor.summernote('insertImage', response.url);
                        },
                        error: function() {
                            console.error('Image upload failed');
                        }
                    });
                }
            }
        });
        $('#submit-button').on('click', function() {
            var $button = $(this);
            $button.prop('disabled', true); // Disable the button
            $button.html('<i class="bi bi-hourglass-split mx-2"></i> Loading...'); // Change button text to loading state
            $button.closest('form').submit(); // Submit the form
        });
    });
</script>

@endpush