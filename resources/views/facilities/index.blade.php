@extends('layouts.dashboard')
@section('button')
    <li class="nav-item mr-2">
        <a href="{{ url('/facilities/create') }}" class="btn btn-primary nav-link" style="color: white">+ Tambah</a>
    </li>
@endsection
@section('isi')
    <div class="d-none d-md-block">
        <form action="{{ url('/facilities') }}" class="mr-2 ml-2">
            <div class="form-row mb-2">
                <div class="col-10">
                    <input type="text" class="form-control" name="search" placeholder="Cari.." id="search" value="{{ request('search') }}">
                </div>
                <div class="col">
                    <button type="submit" id="search" class="btn"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
    </div>

    <div class="container-fluid">
        <div class="card p-4">
            <div class="table-responsive" style="border-radius: 10px">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" style="position: sticky; left: 0; background-color: rgb(215, 215, 215); z-index: 2;">No.</th>
                            <th style="width: 50%; background-color:rgb(243, 243, 243);" class="text-center">Fasilitas</th>
                            <th style="width: 20%; background-color:rgb(243, 243, 243);" class="text-center">Created By</th>
                            <th style="width: 20%; background-color:rgb(243, 243, 243);" class="text-center">Updated By</th>
                            <th style="background-color:rgb(243, 243, 243);" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($facilities) <= 0)
                            <tr>
                                <td colspan="10" class="text-center">Tidak Ada Data</td>
                            </tr>
                        @else
                            @foreach ($facilities as $key => $facility)
                                <tr>
                                    <td class="text-center" style="position: sticky; left: 0; background-color: rgb(235, 235, 235); z-index: 1; vertical-align: middle;">{{ ($facilities->currentpage() - 1) * $facilities->perpage() + $key + 1 }}.</td>
                                    <td class="text-center" style="vertical-align: middle;">{{ $facility->name ?? '-' }}</td>
                                    <td class="text-center" style="vertical-align: middle;">{{ $facility->createdBy->name ?? '-' }}</td>
                                    <td class="text-center" style="vertical-align: middle;">{{ $facility->updatedBy->name ?? '-' }}</td>
                                    <td style="vertical-align: middle;">
                                        <div style="display: flex; gap: 5px;">
                                            <a href="{{ url('/facilities/edit/'.$facility->id) }}" class="btn btn-primary btn-sm" style="border-radius: 10px;" title="Edit facility"><i class="fa fa-edit"></i></a>

                                            <form action="{{ url('/facilities/delete/'.$facility->id) }}" method="post">
                                                @method('delete')
                                                @csrf
                                                <button title="Delete facility" class="border-0 btn btn-danger btn-sm" style="border-radius: 10px;" onClick="return confirm('Are You Sure')"><i class="fa fa-trash"></i></button>
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
                {{ $facilities->links() }}
            </div>
        </div>
    </div>
@endsection




