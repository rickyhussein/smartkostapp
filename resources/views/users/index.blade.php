@extends('layouts.dashboard')
@section('button')
    <li class="nav-item mr-2">
        <a href="{{ url('/users/create') }}" class="btn btn-primary nav-link" style="color: white">+ Tambah</a>
    </li>
@endsection
@section('isi')
    <div class="container-fluid">
        <form action="{{ url('/users') }}">
            <div class="form-row mb-2">
                <div class="col-11">
                    <input type="text" class="form-control" name="search" placeholder="Search.." id="search" value="{{ request('search') }}">
                </div>
                <div class="col-1">
                    <button type="submit" id="search" class="btn"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>

        <div class="card p-4" style="border-radius: 10px;">
            <div class="table-responsive" style="border-radius: 10px;">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" style="position: sticky; left: 0; background-color: rgb(215, 215, 215); z-index: 2;">No.</th>
                            <th style="min-width: 250px; background-color:rgb(243, 243, 243);" class="text-center">Name</th>
                            <th style="min-width: 170px; background-color:rgb(243, 243, 243);" class="text-center">Photo</th>
                            <th style="min-width: 170px; background-color:rgb(243, 243, 243);" class="text-center">Username</th>
                            <th style="min-width: 250px; background-color:rgb(243, 243, 243);" class="text-center">Email</th>
                            <th style="min-width: 170px; background-color:rgb(243, 243, 243);" class="text-center">Phone Number</th>
                            <th style="min-width: 300px; background-color:rgb(243, 243, 243);" class="text-center">Role</th>
                            <th style="background-color:rgb(243, 243, 243);" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($users) <= 0)
                            <tr>
                                <td colspan="10" class="text-center">Tidak Ada Data</td>
                            </tr>
                        @else
                            @foreach ($users as $key => $user)
                                <tr>
                                    <td class="text-center" style="position: sticky; left: 0; background-color: rgb(235, 235, 235); z-index: 1; vertical-align: middle;">{{ ($users->currentpage() - 1) * $users->perpage() + $key + 1 }}.</td>
                                    <td class="text-center" style="vertical-align: middle;">{{ $user->name }}</td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        @if($user->profile_photo)
                                            <img style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover;" src="{{ url('/storage/'.$user->profile_photo) }}" alt="{{ $user->name ?? '-' }}">
                                        @else
                                            <img style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover;" src="{{ url('assets/img/foto_default.jpg') }}" alt="{{ $user->name ?? '-' }}">
                                        @endif
                                    </td>
                                    <td class="text-center" style="vertical-align: middle;">{{ $user->username ?? '-' }}</td>
                                    <td class="text-center" style="vertical-align: middle;">{{ $user->email ?? '-' }}</td>
                                    <td class="text-center" style="vertical-align: middle;">{{ $user->phone_number ?? '-' }}</td>
                                    <td style="vertical-align: middle;">
                                        @if (count($user->roles) > 0)
                                            @foreach ($user->roles as $role)
                                                <div class="badge" style="color: #0a58ca; border:1px solid #0a58ca; background-color: #cbe0ff; border-radius:5px;">{{ $role->name ?? '-' }}</div>
                                            @endforeach
                                        @else
                                            <div class="text-center">-</div>
                                        @endif
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <div style="display: flex; gap: 5px;">
                                            <a href="{{ url('/users/edit/'.$user->id) }}" class="btn btn-primary btn-sm" style="border-radius: 10px;" title="Edit Users"><i class="fa fa-edit"></i></a>

                                            <a href="{{ url('/users/password/edit/'.$user->id) }}" class="btn btn-warning btn-sm" style="border-radius: 10px;" title="Edit Password"><i class="fa fa-key"></i></a>

                                            <form action="{{ url('/users/delete/'.$user->id) }}" method="post">
                                                @method('delete')
                                                @csrf
                                                <button style="border-radius: 10px;" title="Delete Users" class="border-0 btn btn-danger btn-sm" onClick="return confirm('Are You Sure')"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end mr-4 mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection




