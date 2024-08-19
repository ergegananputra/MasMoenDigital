@extends('layouts.app')

@section('head-style')
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN' crossorigin='anonymous'>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL' crossorigin='anonymous'></script>

    {{-- Add Tailwind Hero Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .safezone {
            padding-top: max(10vh, 100px);
            padding-bottom: 10vh;
        }
        .text-center {
            text-align: center;
        }

        .card.kategori {
            border-radius: 16px;
            position: relative; /* Ensure the card is positioned relative for the pseudo-element */
            outline: none;
            border: none;
            transition: 0.3s ease-in-out;
            box-shadow: 12px 12px 12px rgba(76, 73, 73, 0.1), 
                -10px -10px 10px rgb(252, 253, 255); 
        }
    </style>
@endsection

@section('content')
<div class="safezone">
    <div class="container">
        <h1 class="text-4xl font-bold">Kelola Kategori</h1>

        <div class="card kategori mb-4">
            <div class="card-body">
                @isset($category)
                    <h4>Edit Kategori</h4>
                @else
                    <h4>Tambahkan Kategori</h4>
                @endisset
                
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <form 
                @isset($category)
                    action="{{ route('management.categories.update', $category->id) }}"
                @else
                    action="{{ route('management.categories.store') }}" 
                @endisset
                method="POST">
                    @csrf
                    <div class="form-group row my-3">
                        <label for="name" class="col-md-2 col-form-label">Nama Kategori</label>
                        <div class="col-md-10">
                            <input type="text" name="name" id="name" class="form-control"
                                @isset($category)
                                    value="{{ $category->name }}"
                                @endisset
                                >
                        </div>
                    </div>
                    
                    @isset($category)
                        @method('PUT')
                        <div class="row align-items-center mt-2">
                            <div class="col-md-2">
                                <a href="{{ route('management.categories.index') }}" class="btn btn-secondary w-100">
                                    <i class="bi bi-arrow-left mx-2"></i>Kembali
                                </a>
                            </div>
                            <div class="col-md-10">
                                <button type="submit" class="btn btn-warning w-100">
                                    <i class="bi bi-pencil-square mx-2"></i>Perbarui
                                </button>
                            </div>
                        </div>
                        
                    @else 
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-plus-lg mx-2"></i>Tambahkan
                        </button>
                    @endisset
                </form>
            </div>
        </div>
        
        @if (session('create'))
            <div class="alert alert-success mt-2" role="alert">
                {{ session('create') }}
            </div>
        @endif
        @if (session('update'))
            <div class="alert alert-warning mt-2" role="alert">
                {{ session('update') }}
            </div>
        @endif
        @if (session('delete'))
            <div class="alert alert-danger mt-2" role="alert">
                {{ session('delete') }}
            </div>
        @endif

        <div class="card kategori mt-4">
            <div class="card-body">
                <h4>Categories</h4>

                <!-- Search Bar -->
                <div class="mb-3">
                    <input type="text" id="search" class="form-control" placeholder="Cari kategori...">
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-borderless align-middle">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="categoryTable">
                            @foreach ($categories as $category)
                                <tr>
                                    <th scope="row">{{ $category->id }}</th>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        <div class="d-flex justify-content-end">
                                            <a href="{{ route('management.categories.edit', $category->id) }}" class="btn btn-warning mr-4">
                                                <i class="bi bi-pencil-square mx-2"></i>Edit
                                            </a>
                                            <form action="{{ route('management.categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="bi bi-trash mx-2"></i>Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
        
                </div>

            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#search').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('#categoryTable tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
@endpush