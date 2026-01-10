@extends('layouts.appowner')
@section('back')
    <a href="{{ url('/properties/owner') }}" class="back-btn"> <i class="icon-left"></i> </a>
@endsection
@section('container')
    <div id="app-wrap">
        <div class="bill-content">
            <div class="f-carousel" id="myCarousel">
                @php
                    $i = 0;
                @endphp
                @foreach ($property->photos as $photo)
                    @php
                        $i += 1;
                    @endphp
                    <div
                        class="f-carousel__slide"
                        data-fancybox="gallery"
                        data-src="{{ url('/storage/'.$photo->property_file_path) }}"
                        data-thumb-src="{{ url('/storage/'.$photo->property_file_path) }}"
                    >
                        <img
                            data-lazy-src="{{ url('/storage/'.$photo->property_file_path) }}"
                            alt="Image #{{ $i }}"
                        />
                    </div>
                @endforeach
                @foreach ($property->rooms as $room)
                    @php
                        $i += 1;
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
                @endforeach
                @if ($property->video_file_path)
                    @php
                        $i += 1;
                    @endphp
                    <div
                        class="f-carousel__slide"
                        data-fancybox="gallery"
                        data-src="{{ url('/storage/'.$property->video_file_path) }}"
                        data-thumb-src="{{ url('/storage/'.$property->screenshot_video) }}"
                    >
                        <img
                            data-lazy-src="{{ url('/storage/'.$property->screenshot_video) }}"
                            alt="Image #{{ $i }}"
                        />
                    </div>
                @endif
            </div>

            <div class="app-section bg_white_color giftcard-detail-section-1">
                <div class="tf-container">
                    <div class="voucher-info">
                        <a href="#" class="critical_color fw_6">
                            @php
                                $price_from = $property->rooms->min('one_month_price');
                                $price_to = $property->rooms->max('one_month_price');
                            @endphp
                            @if (count($property->rooms) > 1 && ($price_from != $price_to))
                                Rp {{ number_format($price_from) }} ~ Rp {{ number_format($price_to) }}
                            @else
                                Rp {{ number_format($price_from) }}
                            @endif
                        </a>
                        <span class="critical_color">/ Bulan</span>
                        <h2 class="fw_6">{{ $property->name ? ucwords(strtolower($property->name)) : '' }} {{ $property->village && $property->village->name ? ucwords(strtolower($property->village->name)) : '' }}</h2>
                        <br>
                        <div class="badge me-2 mb-2" style="color: gray; border:1px solid gray; background-color:white;"><i class="fas fa-home me-1"></i>{{ $property->category ?? '-' }}</div>
                        <div class="badge me-2 mb-2" style="color: gray; border:1px solid gray; background-color:white;"><i class="fas fa-map-marker-alt me-1"></i>{{ $property->district && $property->district->name ? ucwords(strtolower($property->district->name)) : '' }}</div>
                        <div class="badge me-2 mb-2" style="color: gray; border:1px solid gray; background-color:white;"><i class="fas fa-location-arrow me-1"></i>{{ $property->city && $property->city->name ? ucwords(strtolower($property->city->name)) : '' }}</div>
                        @if ($property->status == 'Menunggu Persetujuan Admin')
                            <div class="badge mb-2" style="color: rgb(21, 47, 118); border:1px solid rgb(21, 47, 118); background-color:rgba(210, 229, 255, 0.889); border-radius:5px;">{{ $property->status ?? '-' }}</div>
                        @elseif($property->status == 'Disetujui')
                            <div class="badge mb-2" style="color: rgba(20, 78, 7, 0.889); border:1px solid rgba(20, 78, 7, 0.889); background-color:rgb(208, 255, 187); border-radius:5px;">{{ $property->status ?? '-' }}</div>
                        @else
                            <div class="badge mb-2" style="color: rgba(78, 26, 26, 0.889); border:1px solid rgba(78, 26, 26, 0.889); background-color:rgb(255, 209, 209); border-radius:5px;">{{ $property->status ?? '-' }}</div>
                        @endif
                        <br>
                        Tersisa <span class="critical_color">{{ $property->countUnavailable($property->id) }} Kamar</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center top mt-4">
                        <span>
                            <h4 class="fw_6">
                                Kos dikelola oleh
                            </h4>
                            {{ $property->admin_name }}
                            <br>
                            <a target="_blank" href="https://wa.me/{{ $property->whatsapp($property->admin_number) }}" class="badge me-2" style="color: rgb(4, 149, 50); border:1px solid rgb(4, 149, 50); background-color:white; "><i class="fab fa-whatsapp"></i> Whatsapp</a>
                            <a target="_blank" href="tel:{{ $property->admin_number }}" class="badge ml-2" style="color: gray; border:1px solid gray; background-color:white; "><i class="fas fa-phone-volume"></i> Call</a>
                        </span>
                        @if($property->user && $property->user->profile_photo == null)
                            <img src="{{ url('/assets/img/foto_default.jpg') }}" alt="image" style="width: 50px; height: 50px; border-radius:50px;">
                        @else
                            <img src="{{ url('/storage/'.$property->user->profile_photo) }}" alt="image" style="width: 50px; height: 50px; border-radius:50px;">
                        @endif
                    </div>
                    <hr style="color: rgb(180, 180, 180)">
                    <div class="voucher-desc">
                        <h4 class="fw_6">Deskripsi</h4>
                        <p class="mt-1">{!! $property->description ? nl2br(e($property->description)) : '-' !!}</p>
                    </div>
                    <hr style="color: rgb(180, 180, 180)">
                    <div class="voucher-desc">
                        <h4 class="fw_6">Fasilitas</h4>
                        <div class="row">
                            @foreach ($property->facilities as $pf)
                                <div class="col-6">
                                    <p class="mt-1"><i class="fa fa-check-circle me-1"></i>{{ $pf->facility->name ?? '-' }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <hr style="color: rgb(180, 180, 180)">
                    <div class="voucher-desc">
                        <h4 class="fw_6">Peraturan</h4>
                        @foreach ($property->regulations as $pr)
                            <p class="mt-1"><i class="fa fa-check-circle me-1"></i>{{ $pr->regulation->name ?? '-' }}</p>
                        @endforeach
                        @if ($property->regulation_file_path)
                            <div class="mt-4">
                                <center>
                                    <a href="{{ url('/storage/'.$property->regulation_file_path) }}">
                                        <img src="{{ url('/storage/'.$property->regulation_file_path) }}" style="max-width: 300px; max-height: 300px; border-radius: 15px;">
                                    </a>
                                </center>
                            </div>
                        @endif
                    </div>
                    <hr style="color: rgb(180, 180, 180)">
                    <div class="voucher-desc">
                        <h4 class="fw_6">Kamar Kosong</span>: {{ $property->countAvailable($property->id) }} Kamar</h4>
                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.5rem;">
                            @foreach ($property->roomAvailable($property->id) as $ra)
                                <a href="{{ url('/properties/owner/room/show/'.$ra->id.'/'.$property->id) }}" style="color: black; text-decoration: none;">
                                    <div class="card mt-4" style="border-radius: 15px; width: 100%;">
                                        <img style="max-height: 150px; border-top-left-radius: 15px; border-top-right-radius: 15px; width: 100%; object-fit: cover;" src="{{ url('/storage/'.$ra->room_file_path) }}" class="card-img-top" alt="">
                                        <div class="card-body">
                                            <h5 class="card-title">Kamar {{ $ra->room_name ? ucwords(strtolower($ra->room_name)) : '' }} Tipe {{ $ra->room_type ? ucwords(strtolower($ra->room_type)) : '' }}</h5>
                                            <div class="badge me-2" style="color: gray; border:1px solid gray; background-color:white; font-size:8px"><i class="fas fa-home me-1"></i>Lantai {{ $ra->floor ?? '-' }}</div>
                                            <div class="badge me-2" style="color: gray; border:1px solid gray; background-color:white; font-size:8px"><i class="far fa-square me-1"></i>{{ $ra->room_height ?? '-' }} x {{ $ra->room_width ?? '-' }} Meter</div>
                                            <br>
                                            <div style="font-size: 8px;">
                                                <span style="float: left;">Harga 1 Bulan</span>
                                                <span style="float: right;" class="critical_color">Rp {{ number_format($ra->one_month_price) }}</span>
                                            </div>
                                            <br>
                                            @if ($ra->three_month_price > 0)
                                                <div style="font-size: 8px;">
                                                    <span style="float: left;">Harga 3 Bulan</span>
                                                    <span style="float: right;" class="critical_color">Rp {{ number_format($ra->three_month_price) }}</span>
                                                </div>
                                                <br>
                                            @endif
                                            @if ($ra->six_month_price > 0)
                                                <div style="font-size: 8px;">
                                                    <span style="float: left;">Harga 6 Bulan</span>
                                                    <span style="float: right;" class="critical_color">Rp {{ number_format($ra->six_month_price) }}</span>
                                                </div>
                                                <br>
                                            @endif
                                            @if ($ra->twelve_month_price > 0)
                                                <div style="font-size: 8px;">
                                                    <span style="float: left;">Harga 12 Bulan</span>
                                                    <span style="float: right;" class="critical_color">Rp {{ number_format($ra->twelve_month_price) }}</span>
                                                </div>
                                                <br>
                                            @endif
                                            @if ($ra->deposit_price > 0)
                                                <div style="font-size: 8px;">
                                                    <span style="float: left;">Biaya Deposit</span>
                                                    <span style="float: right;" class="critical_color">Rp {{ number_format($ra->deposit_price) }}</span>
                                                </div>
                                                <br>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>

                    </div>
                    <hr style="color: rgb(180, 180, 180)">
                    <div class="voucher-desc">
                        <h4 class="fw_6">Kamar Terisi</span>: {{ $property->countUnavailable($property->id) }} Kamar</h4>
                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.5rem;">
                            @foreach ($property->roomUnavailable($property->id) as $ru)
                                <a href="{{ url('/storage/'.$ru->room_file_path) }}" target="_blank" style="color: black; text-decoration: none;">
                                    <div class="card mt-4" style="border-radius: 15px; width: 100%;">
                                        <img style="max-height: 150px; border-top-left-radius: 15px; border-top-right-radius: 15px; width: 100%; object-fit: cover;" src="{{ url('/storage/'.$ru->room_file_path) }}" class="card-img-top" alt="">
                                        <div class="card-body">
                                            <h5 class="card-title">Kamar {{ $ru->room_name ?? '-' }} Tipe {{ $ru->room_type ? ucwords(strtolower($ru->room_type)) : '' }}</h5>
                                            <div class="badge me-2" style="color: gray; border:1px solid gray; background-color:white; font-size:8px"><i class="fas fa-home me-1"></i>Lantai {{ $ru->floor ?? '-' }}</div>
                                            <div class="badge me-2" style="color: gray; border:1px solid gray; background-color:white; font-size:8px"><i class="far fa-square me-1"></i>{{ $ru->room_height ?? '-' }} x {{ $ru->room_width ?? '-' }} Meter</div>
                                            <br>
                                            <div style="font-size: 8px;">
                                                <span style="float: left;">Harga 1 Bulan</span>
                                                <span style="float: right;" class="critical_color">Rp {{ number_format($ru->one_month_price) }}</span>
                                            </div>
                                            <br>
                                            @if ($ru->three_month_price > 0)
                                                <div style="font-size: 8px;">
                                                    <span style="float: left;">Harga 3 Bulan</span>
                                                    <span style="float: right;" class="critical_color">Rp {{ number_format($ru->three_month_price) }}</span>
                                                </div>
                                                <br>
                                            @endif
                                            @if ($ru->six_month_price > 0)
                                                <div style="font-size: 8px;">
                                                    <span style="float: left;">Harga 6 Bulan</span>
                                                    <span style="float: right;" class="critical_color">Rp {{ number_format($ru->six_month_price) }}</span>
                                                </div>
                                                <br>
                                            @endif
                                            @if ($ru->twelve_month_price > 0)
                                                <div style="font-size: 8px;">
                                                    <span style="float: left;">Harga 12 Bulan</span>
                                                    <span style="float: right;" class="critical_color">Rp {{ number_format($ru->twelve_month_price) }}</span>
                                                </div>
                                                <br>
                                            @endif
                                            @if ($ru->deposit_price > 0)
                                                <div style="font-size: 8px;">
                                                    <span style="float: left;">Biaya Deposit</span>
                                                    <span style="float: right;" class="critical_color">Rp {{ number_format($ru->deposit_price) }}</span>
                                                </div>
                                                <br>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <hr style="color: rgb(180, 180, 180)">
                    <div class="voucher-desc">
                        <h4 class="fw_6">Alamat</h4>
                        <p class="mt-1">
                            @if ($property->latitude && $property->longitude)
                                <a href="https://www.google.com/maps?q={{ $property->latitude }},{{ $property->longitude }}" target="_blank" class="text-decoration-none">
                                    <i class="fas fa-map-marker-alt me-1"></i> {{ $property->address }}
                                </a>
                            @else
                                <a href="https://www.google.com/maps?q={{ $property->address }}" target="_blank" class="text-decoration-none">
                                    <i class="fas fa-map-marker-alt me-1"></i> {{ $property->address }}
                                </a>
                            @endif
                        </p>

                        <div id="map" style="height: 300px; border-radius: 8px; margin-top: 15px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($property->status !== 'Disetujui')
        <div class="bottom-navigation-bar st2 bottom-btn-fixed" style="bottom:65px">
            <div class="tf-container">
                <div class="row">
                    <div class="col">
                        <a class="tf-btn small" style="color: green; border:1px solid green; background-color:white;" href="{{ url('/properties/owner/edit/'.$property->id) }}"><i class="fas fa-pencil-alt"></i>Edit</a>
                    </div>
                    <div class="col">
                        <a id="btn-logout" href="#" class="tf-btn small" style="color: red; border:1px solid red; background-color:white;"><i class="fas fa-trash"></i>Hapus</a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="tf-panel logout">
        <div class="panel_overlay"></div>
        <div class="panel-box panel-center panel-logout">
                <div class="heading">
                    <h2 class="text-center">Anda yakin ingin menghapus data ini?</h2>
                </div>
                <div class="bottom">
                    <a class="clear-panel" href="#">Cancel</a>
                    <a class="clear-panel critical_color" href="{{ url('/properties/owner/delete/'.$property->id) }}">Delete</a>
                </div>
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
            let lat = {{ $property->latitude ?? '-6.200000' }};
            let lng = {{ $property->longitude ?? '106.816666' }};
            let address = "{{ $property->address ?? 'Lokasi terpilih' }}";

            map = L.map('map').setView([lat, lng], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            marker = L.marker([lat, lng], {
                draggable: true
            }).addTo(map)
            .bindPopup(address)
            .openPopup();

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
