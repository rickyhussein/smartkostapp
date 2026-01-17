@extends('layouts.appowner')
@section('back')
    <a href="{{ url('/properties/user/show/'.$property->id) }}" class="back-btn"> <i class="icon-left"></i> </a>
@endsection
@section('container')
    <div id="app-wrap">
        <div class="bill-content">
            <div class="f-carousel" id="myCarousel">
                @php
                    $i = 1;
                @endphp

                <div
                    class="f-carousel__slide"
                    data-fancybox="gallery"
                    data-src="{{ url('/storage/'.$room->room_file_path) }}"
                    data-thumb-src="{{ url('/storage/'.$room->room_file_path) }}"
                >
                    <img
                        data-lazy-src="{{ url('/storage/'.$room->room_file_path) }}"
                        alt="Image #{{ $i }}"
                    />
                </div>
                
                @foreach ($room_photos as $photo)
                    @php
                        $i += 1;
                    @endphp
                    <div
                        class="f-carousel__slide"
                        data-fancybox="gallery"
                        data-src="{{ url('/storage/'.$photo->room_photo_file_path) }}"
                        data-thumb-src="{{ url('/storage/'.$photo->room_photo_file_path) }}"
                    >
                        <img
                            data-lazy-src="{{ url('/storage/'.$photo->room_photo_file_path) }}"
                            alt="Image #{{ $i }}"
                        />
                    </div>
                @endforeach
            </div>

            <div class="app-section bg_white_color giftcard-detail-section-1">
                <div class="tf-container">
                    <div class="voucher-info">
                        <h2 class="fw_6">Kamar {{ $room->room_name ? ucwords(strtolower($room->room_name)) : '' }} Tipe {{ $room->room_type ? ucwords(strtolower($room->room_type)) : '' }}</h2>

                        <div class="badge me-2" style="color: gray; border:1px solid gray; background-color:white; font-size:8px"><i class="fas fa-home me-1"></i>Lantai {{ $room->floor ?? '-' }}</div>

                        <div class="badge me-2" style="color: gray; border:1px solid gray; background-color:white; font-size:8px"><i class="far fa-square me-1"></i>{{ $room->room_height ?? '-' }} x {{ $room->room_width ?? '-' }} Meter</div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center top mt-4">
                        <h4 class="fw_6">Harga 1 Bulan</h4>

                        <h4 class="fw_6 critical_color">Rp {{ number_format($room->one_month_price) }}</h4>
                    </div>
                    <hr style="color: rgb(180, 180, 180)">

                    @if ($room->three_month_price)
                        <div class="d-flex justify-content-between align-items-center top mt-4">
                            <h4 class="fw_6">Harga 3 Bulan</h4>

                            <h4 class="fw_6 critical_color">Rp {{ number_format($room->three_month_price) }}</h4>
                        </div>
                        <hr style="color: rgb(180, 180, 180)">
                    @endif
                    
                    @if ($room->six_month_price)
                        <div class="d-flex justify-content-between align-items-center top mt-4">
                            <h4 class="fw_6">Harga 6 Bulan</h4>

                            <h4 class="fw_6 critical_color">Rp {{ number_format($room->six_month_price) }}</h4>
                        </div>
                        <hr style="color: rgb(180, 180, 180)">
                    @endif

                    @if ($room->twelveth_price)
                        <div class="d-flex justify-content-between align-items-center top mt-4">
                            <h4 class="fw_6">Harga 12 Bulan</h4>

                            <h4 class="fw_6 critical_color">Rp {{ number_format($room->twelve_month_price) }}</h4>
                        </div>
                        <hr style="color: rgb(180, 180, 180)">
                    @endif

                    @if ($room->deposit_price)
                        <div class="d-flex justify-content-between align-items-center top mt-4">
                            <h4 class="fw_6">Biaya Deposit</h4>

                            <h4 class="fw_6 critical_color">Rp {{ number_format($room->deposit_price) }}</h4>
                        </div>
                        <hr style="color: rgb(180, 180, 180)">
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <br><br><br><br>

    <div class="bottom-navigation-bar st2 bottom-btn-fixed" style="bottom:65px">
        <div class="tf-container">
            <a class="tf-btn small" style="color: green; border:1px solid green; background-color:white;" href="{{ url('/properties/user/rents/'.$property->id.'?room_id='.$room->id) }}">Sewa Kos Ini</a>
        </div>
    </div>


    @push('style')
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.0/dist/fancybox/fancybox.css"
        />
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.0/dist/carousel/carousel.css"
        />
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.0/dist/carousel/carousel.lazyload.css"
        />
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.0/dist/carousel/carousel.arrows.css"
        />
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.0/dist/carousel/carousel.thumbs.css"
        />
        <style>
            #myCarousel {
                --f-arrow-pos: 10px;
                --f-arrow-bg: rgba(255,255,255,0.75);
                --f-arrow-hover-bg: rgba(255,255,255,1);
                --f-arrow-color: #333;
                --f-arrow-width: 40px;
                --f-arrow-height: 40px;
                --f-arrow-svg-width: 20px;
                --f-arrow-svg-height: 20px;
                --f-arrow-svg-stroke-width: 2px;
                --f-arrow-border-radius: 50%;

                height: 400px;
            }

            #myCarousel .f-carousel__slide {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            #myCarousel img {
                max-width: 100%;
                max-height: 100%;
                height: auto;
            }
        </style>
    @endpush

    @push('script')
        <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.0/dist/fancybox/fancybox.umd.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.0/dist/carousel/carousel.umd.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.0/dist/carousel/carousel.lazyload.umd.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.0/dist/carousel/carousel.arrows.umd.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.0/dist/carousel/carousel.thumbs.umd.js"></script>
        <script>
            Carousel(document.getElementById("myCarousel"), {
            }, {
                Lazyload,
                Arrows,
                Thumbs
            }).init();

            Fancybox.bind("[data-fancybox]", {
            });
        </script>
    @endpush
@endsection
