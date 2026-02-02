@extends('layouts.appowner')
@section('back')
    <a href="{{ url('/dashboard/owner') }}" class="back-btn"> <i class="icon-left"></i> </a>
@endsection
@section('container')
    <div id="app-wrap" class="style1">
        <div class="tf-container">
            <form action="{{ url('/property-room/owner') }}" class="mt-4">
                <div class="row">
                    <div class="col-10">
                        <input type="text" name="search" placeholder="Search.." id="search" value="{{ request('search') }}">
                    </div>
                    <div class="col-2">
                        <button type="submit" class="btn"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>

            @if (count($property_rooms) <= 0)
                <div class="d-flex justify-content-center align-items-center vh-100">
                    <div class="bill-content text-center">
                        <div class="tf-container">
                            <p class="m-0">Data not available</p>
                        </div>
                    </div>
                </div>
            @else
                @foreach ($property_rooms as $pr)
                    <a href="{{ url('/properties/owner/room/show/'.$pr->id.'/'.$pr->property_id) }}" style="color: black; text-decoration: none;">
                        <div class="card mt-4" style="border-radius: 15px; width: 100%;">
                            <img style="max-height: 150px; border-top-left-radius: 15px; border-top-right-radius: 15px; width: 100%; object-fit: cover;" src="{{ url('/storage/'.$pr->room_file_path) }}" class="card-img-top" alt="">
                            <div class="card-body">
                                <h5 class="card-title">{{ $pr->property && $pr->property->name ? ucwords(strtolower($pr->property->name)) : '' }} - Kamar {{ $pr->room_name ? ucwords(strtolower($pr->room_name)) : '' }} Tipe {{ $pr->room_type ? ucwords(strtolower($pr->room_type)) : '' }}</h5>
                                <div class="badge me-2" style="color: gray; border:1px solid gray; background-color:white; font-size:8px"><i class="fas fa-home me-1"></i>Lantai {{ $pr->floor ?? '-' }}</div>
                                <div class="badge me-2" style="color: gray; border:1px solid gray; background-color:white; font-size:8px"><i class="far fa-square me-1"></i>{{ $pr->room_height ?? '-' }} x {{ $pr->room_width ?? '-' }} Meter</div>
                                <br>
                                <div style="font-size: 8px;">
                                    <span style="float: left;">Harga 1 Bulan</span>
                                    <span style="float: right;" class="critical_color">Rp {{ number_format($pr->one_month_price) }}</span>
                                </div>
                                <br>
                                @if ($pr->three_month_price > 0)
                                    <div style="font-size: 8px;">
                                        <span style="float: left;">Harga 3 Bulan</span>
                                        <span style="float: right;" class="critical_color">Rp {{ number_format($pr->three_month_price) }}</span>
                                    </div>
                                    <br>
                                @endif
                                @if ($pr->six_month_price > 0)
                                    <div style="font-size: 8px;">
                                        <span style="float: left;">Harga 6 Bulan</span>
                                        <span style="float: right;" class="critical_color">Rp {{ number_format($pr->six_month_price) }}</span>
                                    </div>
                                    <br>
                                @endif
                                @if ($pr->twelve_month_price > 0)
                                    <div style="font-size: 8px;">
                                        <span style="float: left;">Harga 12 Bulan</span>
                                        <span style="float: right;" class="critical_color">Rp {{ number_format($pr->twelve_month_price) }}</span>
                                    </div>
                                    <br>
                                @endif
                                @if ($pr->deposit_price > 0)
                                    <div style="font-size: 8px;">
                                        <span style="float: left;">Biaya Deposit</span>
                                        <span style="float: right;" class="critical_color">Rp {{ number_format($pr->deposit_price) }}</span>
                                    </div>
                                    <br>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
                <div class="d-flex justify-content-end me-4 mt-4">
                    {{ $property_rooms->links() }}
                </div>
            @endif
        </div>
    </div>


    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

    @push('script')
        <script>
        </script>
    @endpush

@endsection
