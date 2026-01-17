@extends('layouts.app')
@section('back')
    <a href="{{ url('/dashboard/user') }}" class="back-btn"> <i class="icon-left"></i> </a>
@endsection
@section('container')
    <div id="app-wrap" class="style1">
        <div class="tf-container">
            <form action="{{ url('/user-properties') }}" class="mt-4">
                <div class="row">
                    <div class="col-10">
                        <input type="text" name="search" placeholder="Search.." id="search" value="{{ request('search') }}">
                    </div>
                    <div class="col-2">
                        <button type="submit" class="btn"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>

            @if (count($user_properties) <= 0)
                <div class="d-flex justify-content-center align-items-center vh-100">
                    <div class="bill-content text-center">
                        <div class="tf-container">
                            <p class="m-0">Data not available</p>
                        </div>
                    </div>
                </div>
            @else
                @foreach ($user_properties as $up)
                    <div class="mt-4">
                        <a href="{{ url('/user-properties/show/'.$up->id) }}">
                            <div class="card text-dark bg-light mb-3" style="border-radius: 15px;">
                                <div class="card-body">
                                    <div class="row  d-flex align-items-center">
                                        <div class="col-4">
                                        <img src="{{ url('/storage/'.$up->room->room_file_path) }}" alt="image" style="max-height: 70px; border-radius:10px;">
                                    </div>
                                    <div class="col-8">
                                        {{ $up->property && $up->property->name ? ucwords(strtolower($up->property->name)) : '' }} {{ $up->property && $up->property->village && $up->property->village->name ? ucwords(strtolower($up->property->village->name)) : '' }}
                                        <br>
                                        Kamar {{ $up->room->room_name ?? '-' }} {{ $up->room->room_type ? '- Tipe ' . $up->room->room_type : '' }} {{ $up->room->floor ? '- Lantai ' . $up->room->floor : '' }}
                                        <br>
                                        @php
                                            $facility = '';
                                        @endphp
                                        @if ($up->property && count($up->property->facilities) > 0)
                                            @foreach ($up->property->facilities as $pf)
                                                @php
                                                    $pemisah = !$loop->last ? ', ' : '';
                                                    $facility .= $pf->facility->name . $pemisah;
                                                @endphp
                                            @endforeach
                                        @endif
                                        <span style="color: rgb(169, 169, 169)">{{ Str::limit($facility, 32, '...') }}</span>
                                        <h6 style="font-size: 10px;" class="mt-1">Rp {{ number_format($up->total_amount) }} - {{ $up->period }} Bulan</h6>
                                        @if ($up->status == 'Menunggu Persetujuan Owner')
                                            <div class="badge me-1" style="color: rgb(21, 47, 118); border:1px solid rgb(21, 47, 118); background-color:rgba(210, 229, 255, 0.889); border-radius:5x;">{{ $up->status ?? '-' }}</div>
                                        @elseif($up->status == 'Pembayaran Berhasil' || $up->status == 'Check-in')
                                            <div class="badge me-1" style="color: rgba(20, 78, 7, 0.889); border:1px solid rgba(20, 78, 7, 0.889); background-color:rgb(208, 255, 187); border-radius:5x;">{{ $up->status ?? '-' }}</div>
                                        @elseif($up->status == 'Menunggu Pembayaran')
                                            <div class="badge me-1" style="color: rgb(255, 135, 36); border:1px solid rgb(255, 135, 36); background-color:rgba(255, 233, 197, 0.889); border-radius:5x;">{{ $up->status ?? '-' }}</div>
                                        @else
                                            <div class="badge me-1" style="color: rgba(78, 26, 26, 0.889); border:1px solid rgba(78, 26, 26, 0.889); background-color:rgb(255, 209, 209); border-radius:5x;">{{ $up->status ?? '-' }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="d-flex justify-content-end me-4 mt-4">
                            {{ $user_properties->links() }}
                        </div>
                    </div>
                @endforeach
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
            $(document).ready(function() {
                $(document).on('click', '.btn-logout', function(e) {
                    e.preventDefault();
                    const targetModal = $(this).data('target');
                    $(targetModal).addClass("panel-open");
                });

                $(document).on('click', '.panel_overlay, .clear-panel', function(e) {
                    e.preventDefault();
                    $(".logout").removeClass("panel-open");
                });

                $(".clickable").on("click", function() {
                    window.location.href = $(this).data("url");
                });
            });
        </script>
    @endpush

@endsection
