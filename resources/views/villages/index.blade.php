@extends('layouts.dashboard')
@section('button')
    <li class="nav-item mr-2">
        <a href="{{ url('/villages/create') }}" class="btn btn-primary nav-link" style="color: white">+ Tambah</a>
    </li>
    <li class="nav-item mr-2">
        <button type="button" class="btn btn-secondary text-white" data-toggle="modal" data-target="#exampleModalCenter">
            <i class="fas fa-file-import mr-1"></i> Import
        </button>
    </li>
@endsection
@section('isi')
    <div class="d-none d-md-block">
        <form action="{{ url('/villages') }}" class="mr-2 ml-2">
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
                            <th style="width: 30%; background-color:rgb(243, 243, 243);" class="text-center">Kelurahan</th>
                            <th style="width: 30%; background-color:rgb(243, 243, 243);" class="text-center">Kecamatan</th>
                            <th style="width: 15%; background-color:rgb(243, 243, 243);" class="text-center">Created By</th>
                            <th style="width: 15%; background-color:rgb(243, 243, 243);" class="text-center">Updated By</th>
                            <th style="background-color:rgb(243, 243, 243);" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($villages) <= 0)
                            <tr>
                                <td colspan="10" class="text-center">Tidak Ada Data</td>
                            </tr>
                        @else
                            @foreach ($villages as $key => $village)
                                <tr>
                                    <td class="text-center" style="position: sticky; left: 0; background-color: rgb(235, 235, 235); z-index: 1; vertical-align: middle;">{{ ($villages->currentpage() - 1) * $villages->perpage() + $key + 1 }}.</td>
                                    <td class="text-center" style="vertical-align: middle;">{{ $village->name ?? '-' }}</td>
                                    <td class="text-center" style="vertical-align: middle;">{{ $village->district->name ?? '-' }}</td>
                                    <td class="text-center" style="vertical-align: middle;">{{ $village->createdBy->name ?? '-' }}</td>
                                    <td class="text-center" style="vertical-align: middle;">{{ $village->updatedBy->name ?? '-' }}</td>
                                    <td style="vertical-align: middle;">
                                        <div style="display: flex; gap: 5px;">
                                            <a href="{{ url('/villages/edit/'.$village->id) }}" class="btn btn-primary btn-sm" style="border-radius: 10px;" title="Edit Village"><i class="fa fa-edit"></i></a>

                                            <form action="{{ url('/villages/delete/'.$village->id) }}" method="post">
                                                @method('delete')
                                                @csrf
                                                <button title="Delete Village" class="border-0 btn btn-danger btn-sm" style="border-radius: 10px;" onClick="return confirm('Are You Sure')"><i class="fa fa-trash"></i></button>
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
                {{ $villages->links() }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Import Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('/villages/import') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="file_excel">
                            File
                        </label>
                        <input type="file" name="file_excel" id="file_excel" class="form-control @error('file_excel') is-invalid @enderror">
                        @error('file_excel')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
        </div>
    </div>
@endsection




