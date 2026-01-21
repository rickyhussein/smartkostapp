@extends('layouts.app')
@section('back')
    <a href="{{ url('/history/user') }}" class="back-btn"> <i class="icon-left"></i> </a>
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

                @foreach ($room->roomPhotos as $rp)
                    @php
                        $i += 1;
                    @endphp
                    <div
                        class="f-carousel__slide"
                        data-fancybox="gallery"
                        data-src="{{ url('/storage/'.$rp->room_photo_file_path) }}"
                        data-thumb-src="{{ url('/storage/'.$rp->room_photo_file_path) }}"
                    >
                        <img
                            data-lazy-src="{{ url('/storage/'.$rp->room_photo_file_path) }}"
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
                    <div class="voucher-desc">
                        <h2 class="fw_6">{{ $property->name ? ucwords(strtolower($property->name)) : '' }} {{ $property->village && $property->village->name ? ucwords(strtolower($property->village->name)) : '' }} - Kamar {{ $room->room_name ?? '-' }} {{ $room->room_type ? ' Tipe ' . $room->room_type : '' }} {{ $room->floor ? '- Lantai ' . $room->floor : '' }}</h2>
                        <br>
                        <div class="badge me-2 mb-2" style="color: gray; border:1px solid gray; background-color:white;"><i class="fas fa-home me-1"></i>{{ $property->category ?? '-' }}</div>
                        <div class="badge me-2 mb-2" style="color: gray; border:1px solid gray; background-color:white;"><i class="fas fa-map-marker-alt me-1"></i>{{ $property->district && $property->district->name ? ucwords(strtolower($property->district->name)) : '' }}</div>
                        <div class="badge me-2 mb-2" style="color: gray; border:1px solid gray; background-color:white;"><i class="fas fa-location-arrow me-1"></i>{{ $property->city && $property->city->name ? ucwords(strtolower($property->city->name)) : '' }}</div>
                        <div class="badge me-2 mb-2" style="color: gray; border:1px solid gray; background-color:white; "><i class="far fa-square me-1"></i>{{ $room->room_height ?? '-' }} x {{ $room->room_width ?? '-' }} Meter</div>
                        @if ($up->status == 'Aktif')
                            <div class="badge me-2 mb-2" style="color: rgba(87, 169, 69, 0.889); border:1px solid rgba(87, 169, 69, 0.889); border-radius:5x;"><i class="fa fa-check me-1"></i>{{ $up->status ?? '-' }}</div>
                        @else
                            <div class="badge me-2 mb-2" style="color: rgba(208, 43, 43, 0.889); border:1px solid rgba(208, 43, 43, 0.889);  border-radius:5x;"><i class="fa fa-times me-1"></i>{{ $up->status ?? '-' }}</div>
                        @endif
                        <br>
                        @php
                            if ($up->start_date) {
                                Carbon\Carbon::setLocale('id');
                                $start_date = Carbon\Carbon::createFromFormat('Y-m-d', $up->start_date);
                                $new_start_date = $start_date->translatedFormat('d F Y');
                            } else {
                                $new_start_date = '-';
                            }
                        @endphp
                        @php
                            if ($up->end_date) {
                                Carbon\Carbon::setLocale('id');
                                $end_date = Carbon\Carbon::createFromFormat('Y-m-d', $up->end_date);
                                $new_end_date = $end_date->translatedFormat('d F Y');
                            } else {
                                $new_end_date = '-';
                            }
                        @endphp
                        <span class="critical_color">Periode {{ $new_start_date }} - {{ $new_end_date }}</span>
                    </div>
                    <hr style="color: rgb(30, 30, 30)">

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
                    <hr style="color: rgb(30, 30, 30)">

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

                    <hr style="color: rgb(30, 30, 30)">
                    <div class="voucher-desc">
                        <h4 class="fw_6">Keluhan</h4>
                        <br>
                        <div class="card mb-4" style="border-radius: 15px;">
                            <div class="card-body">
                                <ul class="mt-3">
                                    @foreach ($complaints as $complaint)
                                        <li class="list-card-invoice">
                                            <div class="content-right">
                                                <h4>
                                                    <a href="#">
                                                        {{ $complaint->type ?? '-' }}
                                                        <span class="critical_color">
                                                            @if ($complaint->status == 'Selesai')
                                                                <div class="badge" style="color: rgba(87, 169, 69, 0.889); border:1px solid rgba(87, 169, 69, 0.889); border-radius:5x; float: right;">{{ $complaint->status ?? '-' }}</div>
                                                            @else
                                                                <div class="badge" style="color: rgba(208, 43, 43, 0.889); border:1px solid rgba(208, 43, 43, 0.889);  border-radius:5x; float: right;">{{ $complaint->status ?? '-' }}</div>
                                                            @endif
                                                        </span>
                                                    </a>
                                                    <a style="font-size: 12px; font-weight:100;" href="#">
                                                        @php
                                                            if ($complaint->date) {
                                                                Carbon\Carbon::setLocale('id');
                                                                $complaint_date = Carbon\Carbon::createFromFormat('Y-m-d', $complaint->date);
                                                                $new_complaint_date = $complaint_date->translatedFormat('d F Y');
                                                            } else {
                                                                $new_complaint_date = '-';
                                                            }
                                                        @endphp
                                                        {{ $new_complaint_date }}
                                                        <br>
                                                        {!! $complaint->complaint ? nl2br(e($complaint->complaint)) : '-' !!}
                                                    </a>
                                                </h4>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <hr style="color: rgb(30, 30, 30)">

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
                    <hr style="color: rgb(30, 30, 30)">

                    @foreach ($transactions as $key => $transaction)
                        <div class="card mb-4" style="border-radius: 15px;">
                            <div class="card-body">
                                <div class="voucher-desc">
                                    <h4 class="fw_6" style="float: left">Rincian Pembayaran Ke-{{ $key + 1 }}</h4>
                                    @if ($transaction->status == 'paid')
                                        <div class="badge" style="color: rgba(20, 78, 7, 0.889); border:1px solid rgba(20, 78, 7, 0.889); background-color:rgb(208, 255, 187); border-radius:5x; text-transform: uppercase;float: right;">{{ $transaction->status ?? '-' }}</div>
                                    @else
                                        <div class="badge" style="color: rgba(78, 26, 26, 0.889); border:1px solid rgba(78, 26, 26, 0.889); background-color:rgb(255, 209, 209); border-radius:5x; text-transform: uppercase;float: right;">{{ $transaction->status ?? '-' }}</div>
                                    @endif
                                    <br>
                                    <br>
                                    <span style="float: left">Tanggal Mulai Sewa</span>
                                    <span style="float: right">
                                        @php
                                            if ($transaction->start_date) {
                                                Carbon\Carbon::setLocale('id');
                                                $start_date = Carbon\Carbon::createFromFormat('Y-m-d', $transaction->start_date);
                                                $new_start_date = $start_date->translatedFormat('d F Y');
                                            } else {
                                                $new_start_date = '-';
                                            }
                                        @endphp
                                        {{ $new_start_date  }}
                                    </span>
                                    <br>
                                    <span style="float: left">Tanggal Selesai Sewa</span>
                                    <span style="float: right">
                                        @php
                                            if ($transaction->end_date) {
                                                Carbon\Carbon::setLocale('id');
                                                $end_date = Carbon\Carbon::createFromFormat('Y-m-d', $transaction->end_date);
                                                $new_end_date = $end_date->translatedFormat('d F Y');
                                            } else {
                                                $new_end_date = '-';
                                            }
                                        @endphp
                                        {{ $new_end_date  }}
                                    </span>
                                    <br>
                                    <span style="float: left">Periode Kos</span>
                                    <span style="float: right">
                                        {{ $transaction->period ?? '-' }} Bulan
                                    </span>
                                    <br>
                                </div>
                                <hr style="color: rgb(180, 180, 180)">
                                <span style="float: left">Biaya sewa kos</span>
                                <h6 id="textAmount" style="float: right">Rp {{ number_format($transaction->amount) }}</h6>
                                <br>
                                @if ($key == 0)
                                    <span style="float: left">Deposit</span>
                                    <h6 id="textDeposit" style="float: right">Rp {{ number_format($transaction->deposit_price) }}</h6>
                                    <br>
                                @endif
        
                                <div class="voucher-desc">
                                    <h3 style="float: left">Total Pembayaran</h3>
                                    <h3 id="textTotalAmount" style="float: right">Rp {{ number_format($transaction->total_amount) }}</h3>
                                </div>
                                <br>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>


    <br>
    <br>
    <br>
    <br>
    <br>

    @push('style')
        <script type="text/javascript" src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>

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

            .image-preview-container {
                margin-top: 10px;
                padding: 5px;
                border: 1px dashed #ccc;
                border-radius: 4px;
                display: inline-block;
            }
        </style>
    @endpush

    @push('script')
        <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.0/dist/fancybox/fancybox.umd.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.0/dist/carousel/carousel.umd.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.0/dist/carousel/carousel.lazyload.umd.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.0/dist/carousel/carousel.arrows.umd.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.0/dist/carousel/carousel.thumbs.umd.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
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

            var success = sessionStorage.getItem("success");
            if(success !== null){
                Swal.fire(success, '', 'success');
                sessionStorage.removeItem("success");
            }

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
