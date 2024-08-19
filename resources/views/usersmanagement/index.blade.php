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

        .card.usersmanagement {
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
        <h1 class="text-4xl font-bold">Kelola Akun Pengguna</h1>

        @if (session('success'))
            <div class="alert alert-success mt-2" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session('fail'))
            <div class="alert alert-warning mt-2" role="alert">
                {{ session('fail') }}
            </div>
        @endif

        <div class="card usersmanagement my-4">
            <div class="card-body">
                <h4>Daftar Pengguna</h4>
                
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                    <input type="text" id="search" class="form-control" placeholder="Cari pengguna..." aria-label="Cari pengguna..." aria-describedby="basic-addon1">
                </div>

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Nama</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="userTable">
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if ($user->isAdmin())
                                        <h6><span class="badge bg-primary mr-2 mb-2">{{ $user->role }}</span></h6>
                                    @else
                                        <h6><span class="badge bg-secondary mr-2 mb-2">{{ $user->role }}</span></h6>
                                    @endif
                                </td>
                                <td>
                                    @if ($user->isAdmin())
                                        {{-- Demote --}}
                                        <form action="{{ route('management.users.demote', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-warning">Demote</button>
                                        </form>
                                    @else 
                                        {{-- Promote To Admin --}}
                                        <form action="{{ route('management.users.promote', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success">Promote</button>
                                        </form>
                                    @endif
                                    

                                    

                                    <a href="{{ route('management.users.edit', $user->id) }}" class="btn btn-primary">Edit</a>
                                    <form action="{{ route('management.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Apakah anda ingin menghapus pengguna ini?')"
                                            >Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
                $('#userTable tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
@endpush