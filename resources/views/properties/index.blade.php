@extends('layouts.dashboard')
@section('button')
    <li class="nav-item mr-2">
        {{-- <a href="{{ url('/properties/export') }}{{ $_GET?'?'.$_SERVER['QUERY_STRING']: '' }}" class="btn btn-success nav-link" style="color: white"><i class="far fa-file-excel mr-1"></i>Export</a> --}}
    </li>
@endsection
@section('isi')
    <div class="d-none d-md-block">
        <form action="{{ url('/properties') }}" class="mr-2 ml-2">
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
                            <th style="min-width: 220px; background-color:rgb(243, 243, 243);" class="text-center">Nama Kos</th>
                            <th style="min-width: 220px; background-color:rgb(243, 243, 243);" class="text-center">Pemilik Kos</th>
                            <th style="min-width: 170px; background-color:rgb(243, 243, 243);" class="text-center">Jenis Kos</th>
                            <th style="min-width: 400px; background-color:rgb(243, 243, 243);" class="text-center">Alamat</th>
                            <th style="min-width: 400px; background-color:rgb(243, 243, 243);" class="text-center">Harga</th>
                            <th style="min-width: 170px; background-color:rgb(243, 243, 243);" class="text-center">Status</th>
                            <th style="background-color:rgb(243, 243, 243);" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($properties) <= 0)
                            <tr>
                                <td colspan="10" class="text-center">Tidak Ada Data</td>
                            </tr>
                        @else
                            @foreach ($properties as $key => $property)
                                <tr>
                                    <td class="text-center" style="position: sticky; left: 0; background-color: rgb(235, 235, 235); z-index: 1; vertical-align: middle;">{{ ($properties->currentpage() - 1) * $properties->perpage() + $key + 1 }}.</td>
                                    <td class="text-center" style="vertical-align: middle;">{{ $property->name }}</td>
                                    <td class="text-center" style="vertical-align: middle;">{{ $property->user->name }}</td>
                                    <td class="text-center" style="vertical-align: middle;">{{ $property->category }}</td>
                                    <td class="text-center" style="vertical-align: middle;">{{ $property->address }}</td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        @php
                                            $price_from = $property->rooms->min('one_month_price');
                                            $price_to = $property->rooms->max('one_month_price');
                                        @endphp
                                        @if (count($property->rooms) > 1 && ($price_from != $price_to))
                                            Rp {{ number_format($price_from) }} ~ Rp {{ number_format($price_to) }}
                                        @else
                                            Rp {{ number_format($price_from) }}
                                        @endif
                                    </td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        @if ($property->status == 'Menunggu Persetujuan Admin')
                                            <div class="badge" style="color: rgb(21, 47, 118); border:1px solid rgb(21, 47, 118); background-color:rgba(210, 229, 255, 0.889); border-radius:10px;">{{ $property->status ?? '-' }}</div>
                                        @elseif($property->status == 'Disetujui')
                                            <div class="badge" style="color: rgba(20, 78, 7, 0.889); border:1px solid rgba(20, 78, 7, 0.889); background-color:rgb(208, 255, 187); border-radius:10px;">{{ $property->status ?? '-' }}</div>
                                        @else
                                            <div class="badge" style="color: rgba(78, 26, 26, 0.889); border:1px solid rgba(78, 26, 26, 0.889); background-color:rgb(255, 209, 209); border-radius:10px;">{{ $property->status ?? '-' }}</div>
                                        @endif
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <center>
                                            <a href="{{ url('/properties/show/'.$property->id) }}" class="btn btn-primary btn-sm" style="border-radius: 10px;" title="Show property"><i class="fa fa-eye"></i></a>
                                        </center>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end mr-4 mt-4">
                {{ $properties->links() }}
            </div>
        </div>
    </div>
@endsection




