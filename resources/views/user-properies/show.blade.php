@extends('layouts.app')
@section('back')
    <a href="{{ url('/user-properties') }}" class="back-btn"> <i class="icon-left"></i> </a>
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
                    <div class="voucher-info">
                        <h2 class="fw_6">{{ $property->name ? ucwords(strtolower($property->name)) : '' }} {{ $property->village && $property->village->name ? ucwords(strtolower($property->village->name)) : '' }} - Kamar {{ $room->room_name ?? '-' }} {{ $room->room_type ? ' yTipe ' . $room->room_type : '' }} {{ $room->floor ? '- Lantai ' . $room->floor : '' }}</h2>
                        <br>
                        <div class="badge me-2 mb-2" style="color: gray; border:1px solid gray; background-color:white;"><i class="fas fa-home me-1"></i>{{ $property->category ?? '-' }}</div>
                        <div class="badge me-2 mb-2" style="color: gray; border:1px solid gray; background-color:white;"><i class="fas fa-map-marker-alt me-1"></i>{{ $property->district && $property->district->name ? ucwords(strtolower($property->district->name)) : '' }}</div>
                        <div class="badge me-2 mb-2" style="color: gray; border:1px solid gray; background-color:white;"><i class="fas fa-location-arrow me-1"></i>{{ $property->city && $property->city->name ? ucwords(strtolower($property->city->name)) : '' }}</div>
                        <div class="badge me-2 mb-2" style="color: gray; border:1px solid gray; background-color:white; "><i class="far fa-square me-1"></i>{{ $room->room_height ?? '-' }} x {{ $room->room_width ?? '-' }} Meter</div>
                        @if ($up->status == 'Tanda Tangan Kontrak')
                            <div class="badge me-2 mb-2" style="color: rgb(21, 47, 118); border:1px solid rgb(21, 47, 118); background-color:rgba(210, 229, 255, 0.889); border-radius:5x;">{{ $up->status ?? '-' }}</div>
                        @elseif($up->status == 'Pembayaran Berhasil')
                            <div class="badge me-2 mb-2" style="color: rgba(20, 78, 7, 0.889); border:1px solid rgba(20, 78, 7, 0.889); background-color:rgb(208, 255, 187); border-radius:5x;">{{ $up->status ?? '-' }}</div>
                        @elseif($up->status == 'Menunggu Pembayaran')
                            <div class="badge me-2 mb-2" style="color: rgb(255, 135, 36); border:1px solid rgb(255, 135, 36); background-color:rgba(255, 233, 197, 0.889); border-radius:5x;">{{ $up->status ?? '-' }}</div>
                        @else
                            <div class="badge me-2 mb-2" style="color: rgba(78, 26, 26, 0.889); border:1px solid rgba(78, 26, 26, 0.889); background-color:rgb(255, 209, 209); border-radius:5x;">{{ $up->status ?? '-' }}</div>
                        @endif
                    </div>

                    <div class="voucher-desc">
                        <h4 class="fw_6">Informasi Penyewa</h4>
                        <br>
                        <span style="color: black">Nama Penyewa</span>
                        <br>
                        <span style="color: rgb(169, 169, 169)">{{ $up->user->name ?? '-' }}</span>
                        <br>
                        <br>
                        <span style="color: black">Nomor HP</span>
                        <br>
                        <span style="color: rgb(169, 169, 169)">{{ $up->user->phone_number ?? '-' }}</span>
                        <br>
                        <br>
                        <span style="color: black">Jenis Kelamin</span>
                        <br>
                        <span style="color: rgb(169, 169, 169)">{{ $up->user->gender ?? '-' }}</span>
                        <br>
                        <br>
                        <span style="color: black">Pekerjaan</span>
                        <br>
                        <span style="color: rgb(169, 169, 169)">{{ $up->user->job ?? '-' }}</span>
                        <br>
                        <br>
                        <span style="color: black">Nama Kampus / Kantor</span>
                        <br>
                        <span style="color: rgb(169, 169, 169)">{{ $up->user->job_desc ?? '-' }}</span>
                        <br>
                        <br>
                        <span style="color: black">Catatan</span>
                        <br>
                        {!! $up->note ? nl2br(e($up->note)) : '-' !!}
                        <br>
                        <br>
                        <div>
                            <div style="float:right;">
                                <a href="{{ url('/storage/'.$rent->ktp_photo_transaction) }}" target="_blank" class="image-preview-container" id="roomImage">
                                    <img src="{{ url('/storage/'.$rent->ktp_photo_transaction) }}" alt="img-preview" class="img-preview" style="max-width: 80px; max-height: 80px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                </a>
                            </div>
                            <br>
                            <br>
                            <div style="color: black; float:left;">
                                Foto KTP
                            </div>
                        </div>
                        <br>
                        <br>
                        <br>
                        <br>
                        <div>
                            <div style="float:right;">
                                <a href="{{ url('/storage/'.$rent->kk_photo_transaction) }}" target="_blank" class="image-preview-container" id="roomImage">
                                    <img src="{{ url('/storage/'.$rent->kk_photo_transaction) }}" alt="img-preview" class="img-preview" style="max-width: 80px; max-height: 80px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                </a>
                            </div>
                            <br>
                            <br>
                            <div style="color: black; float:left;">
                                Foto KK
                            </div>
                        </div>
                        <br>
                        <br>
                        <br>
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
                    <hr style="color: rgb(180, 180, 180)">
                    
                    @foreach ($transactions as $key => $transaction)
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
                        <br>

                        @if ($transaction->active == 1)
                            <button  id="pay-button" class="tf-btn accent small">Bayar Sekarang</button>

                            @push('head')
                                <script type="text/javascript" src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
                            @endpush

                            @push('foot')
                                <script type="text/javascript">
                                    var payButton = document.getElementById('pay-button');
                                    payButton.addEventListener('click', function () {
                                        window.snap.pay('{{ $transaction->snaptoken }}', {
                                            onSuccess: function(result){
                                                Swal.fire('Payment Success!', '', 'success');
                                                setTimeout(() => location.reload(), 3000);
                                            },
                                            onPending: function(result){
                                                Swal.fire({
                                                    title: "Pending",
                                                    text: "Waiting For Your Payment",
                                                    icon: "info"
                                                });
                                                setTimeout(() => location.reload(), 3000);
                                            },
                                            onError: function(result){
                                                Swal.fire({
                                                    title: "Failed",
                                                    text: "Payment Failed",
                                                    icon: "error"
                                                });
                                                setTimeout(() => location.reload(), 3000);
                                            },
                                            onClose: function(){
                                                Swal.fire({
                                                    title: "Closed",
                                                    text: "You closed The Popup Without Finishing The Payment",
                                                    icon: "warning"
                                                });
                                                setTimeout(() => location.reload(), 3000);
                                            }
                                        })
                                    });
                                </script>
                            @endpush
                        @endif
                        <br>
                        <hr style="color: rgb(30, 30, 30)">
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
