@extends('layouts.dashboard')
@section('button')
    <li class="nav-item mr-2">
        <a href="{{ url('/roles/create') }}" class="btn btn-primary nav-link" style="color: white">+ Tambah</a>
    </li>
@endsection
@section('isi')
    <div class="container-fluid">
        <form action="{{ url('/roles') }}">
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
                            <th style="min-width: 200px; background-color:rgb(243, 243, 243);" class="text-center">Role</th>
                            <th style="min-width: 400px; background-color:rgb(243, 243, 243);" class="text-center">Permissions</th>
                            <th style="min-width: 100px; background-color:rgb(243, 243, 243);" class="text-center">Guard</th>
                            <th style="background-color:rgb(243, 243, 243);" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($roles) <= 0)
                            <tr>
                                <td colspan="10" class="text-center">Tidak Ada Data</td>
                            </tr>
                        @else
                            @foreach ($roles as $key => $role)
                                <tr>
                                    <td class="text-center" style="position: sticky; left: 0; background-color: rgb(235, 235, 235); z-index: 1; vertical-align: middle;">{{ ($roles->currentpage() - 1) * $roles->perpage() + $key + 1 }}.</td>
                                    <td class="text-center" style="vertical-align: middle;">{{ $role->name }}</td>
                                    <td style="vertical-align: middle;">
                                        @if (count($role->permissions) > 0)
                                            @foreach ($role->permissions as $permission)
                                                <div class="badge" style="color: #0a58ca; border:1px solid #0a58ca; background-color: #cbe0ff; border-radius:5px;">{{ $permission->name ?? '-' }}</div>
                                            @endforeach
                                        @else
                                            <div class="text-center">-</div>
                                        @endif
                                    </td>
                                    <td class="text-center" style="vertical-align: middle;">{{ $role->guard_name }}</td>
                                    <td style="vertical-align: middle;">
                                        <div style="display: flex; gap: 5px;">
                                            <a href="{{ url('/roles/edit/'.$role->id) }}" class="btn btn-primary btn-sm" style="border-radius: 10px;" title="Edit roles"><i class="fa fa-edit"></i></a>

                                            <form action="{{ url('/roles/delete/'.$role->id) }}" method="post">
                                                @method('delete')
                                                @csrf
                                                <button style="border-radius: 10px;" title="Delete roles" class="border-0 btn btn-danger btn-sm" onClick="return confirm('Are You Sure')"><i class="fa fa-trash"></i></button>
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
                {{ $roles->links() }}
            </div>
        </div>
    </div>
@endsection




