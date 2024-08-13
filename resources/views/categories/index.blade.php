@extends('layouts.app')

@section('head-style')
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN' crossorigin='anonymous'>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL' crossorigin='anonymous'></script>

    {{-- Add Tailwind Hero Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
 
    </style>
@endsection

@section('content')
    <div class="container">
        <h1 class="text-4xl font-bold">Kelola Kategori</h1>
        
        <h4>Tambahkan Kategori</h4>
        <form class="row" action="{{ route('management.categories.store') }}" method="POST">
            @csrf

            <div class="form-group col-md-10">
                <input type="text" name="name" id="name" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary col-md-2">
                <i class="bi bi-plus-lg mx-2"></i>Tambahkan
            </button>
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </form>
       
        


        <h4>Categories</h4>
        
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <th scope="row">{{ $category->id }}</th>
                        <td>{{ $category->name }}</td>
                        <td>
                            <a href="{{ route('management.categories.edit', $category->id) }}" class="btn btn-warning">
                                <i class="bi bi-pencil-square mx-2"></i>Edit
                            </a>
                            <form action="{{ route('management.categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-trash mx-2"></i>Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection