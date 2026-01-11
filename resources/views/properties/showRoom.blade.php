@extends('layouts.dashboard')
@section('button')
    <li class="nav-item mr-2">
        <a href="{{ url('/properties/show/'.$property->id) }}" class="btn nav-link" style="color: red; border:1px solid red; background-color:white; ">Back</a>
    </li>
@endsection
@section('isi')
    <div class="container-fluid">
        <center>
            <div class="card mt-4" style="border-radius: 15px; width: 40%;">
                <div id="carouselExampleControls{{ $room->id }}" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <a href="{{ url('/storage/'.$room->room_file_path) }}" target="_blank" class="carousel-item active">
                            <img style="max-height: 150px; border-top-left-radius: 15px; border-top-right-radius: 15px; width: 100%; object-fit: cover;" 
                                src="{{ url('/storage/'.$room->room_file_path) }}" 
                                class="d-block w-100 card-img-top" 
                                alt="{{ $room->room_file_name }}">
                        </a>
                        @foreach ($room->roomPhotos as $rp)
                            <a href="{{ url('/storage/'.$rp->room_photo_file_path) }}" target="_blank" class="carousel-item">
                                <img style="max-height: 150px; border-top-left-radius: 15px; border-top-right-radius: 15px; width: 100%; object-fit: cover;" 
                                    src="{{ url('/storage/'.$rp->room_photo_file_path) }}" 
                                    class="d-block w-100 card-img-top" 
                                    alt="{{ $rp->room_photo_file_name }}">
                            </a>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-target="#carouselExampleControls{{ $room->id }}" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-target="#carouselExampleControls{{ $room->id }}" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </button>
                </div>


                <div class="card-body">
                    <h5 class="card-title">Kamar {{ $room->room_name ?? '-' }} Tipe {{ $room->room_type ? ucwords(strtolower($room->room_type)) : '' }}</h5>
                    <br>
                    <div class="badge mr-2" style="color: gray; border:1px solid gray; background-color:white; font-size:9px; float:left;"><i class="fas fa-home mr-1"></i>Lantai {{ $room->floor ?? '-' }}</div>
                    <div class="badge mr-2" style="color: gray; border:1px solid gray; background-color:white; font-size:9px; float:left;"><i class="far fa-square mr-1"></i>{{ $room->room_height ?? '-' }} x {{ $room->room_width ?? '-' }} Meter</div>
                    <br>
                    <br>
                    <div style="font-size: 9px;">
                        <span style="float: left;">Harga 1 Bulan</span>
                        <span style="float: right; color: red;">Rp {{ number_format($room->one_month_price) }}</span>
                    </div>
                    <br>
                    @if ($room->three_month_price > 0)
                        <div style="font-size: 9px;">
                            <span style="float: left;">Harga 3 Bulan</span>
                            <span style="float: right; color: red;">Rp {{ number_format($room->three_month_price) }}</span>
                        </div>
                        <br>
                    @endif
                    @if ($room->six_month_price > 0)
                        <div style="font-size: 9px;">
                            <span style="float: left;">Harga 6 Bulan</span>
                            <span style="float: right; color: red;">Rp {{ number_format($room->six_month_price) }}</span>
                        </div>
                        <br>
                    @endif
                    @if ($room->twelve_month_price > 0)
                        <div style="font-size: 9px;">
                            <span style="float: left;">Harga 12 Bulan</span>
                            <span style="float: right; color: red;">Rp {{ number_format($room->twelve_month_price) }}</span>
                        </div>
                        <br>
                    @endif
                    @if ($room->deposit_price > 0)
                        <div style="font-size: 9px;">
                            <span style="float: left;">Biaya Deposit</span>
                            <span style="float: right; color: red;">Rp {{ number_format($room->deposit_price) }}</span>
                        </div>
                        <br>
                    @endif
                </div>
            </div>
        </center>
    </div>
@endsection
