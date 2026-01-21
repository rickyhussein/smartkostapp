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
                    <div class="voucher-desc">
                        <h2 class="fw_6">{{ $property->name ? ucwords(strtolower($property->name)) : '' }} {{ $property->village && $property->village->name ? ucwords(strtolower($property->village->name)) : '' }} - Kamar {{ $room->room_name ?? '-' }} {{ $room->room_type ? ' Tipe ' . $room->room_type : '' }} {{ $room->floor ? '- Lantai ' . $room->floor : '' }}</h2>
                        <br>
                        <div class="badge me-2 mb-2" style="color: gray; border:1px solid gray; background-color:white;"><i class="fas fa-home me-1"></i>{{ $property->category ?? '-' }}</div>
                        <div class="badge me-2 mb-2" style="color: gray; border:1px solid gray; background-color:white;"><i class="fas fa-map-marker-alt me-1"></i>{{ $property->district && $property->district->name ? ucwords(strtolower($property->district->name)) : '' }}</div>
                        <div class="badge me-2 mb-2" style="color: gray; border:1px solid gray; background-color:white;"><i class="fas fa-location-arrow me-1"></i>{{ $property->city && $property->city->name ? ucwords(strtolower($property->city->name)) : '' }}</div>
                        <div class="badge me-2 mb-2" style="color: gray; border:1px solid gray; background-color:white; "><i class="far fa-square me-1"></i>{{ $room->room_height ?? '-' }} x {{ $room->room_width ?? '-' }} Meter</div>
                        @if ($up->status == 'Tanda Tangan Kontrak')
                            <div class="badge me-2 mb-2" style="color: rgb(21, 47, 118); border:1px solid rgb(21, 47, 118); background-color:rgba(210, 229, 255, 0.889); border-radius:5x;">{{ $up->status ?? '-' }}</div>
                        @endif
                        <br>
                        
                        @php
                            if ($up->end_date) {
                                Carbon\Carbon::setLocale('id');
                                $end_date = Carbon\Carbon::createFromFormat('Y-m-d', $up->end_date);
                                $new_end_date = $end_date->translatedFormat('d F Y');
                            } else {
                                $new_end_date = '-';
                            }
                        @endphp

                        <span class="critical_color"> Berakhir pada {{ $new_end_date }}</span>
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
                                                    <a href="{{ url('/user-properties/complaint/show/'.$complaint->id.'/'.$up->id) }}">
                                                        {{ $complaint->type ?? '-' }}
                                                        <span class="critical_color">
                                                            @if ($complaint->status == 'Selesai')
                                                                <div class="badge" style="color: rgba(87, 169, 69, 0.889); border:1px solid rgba(87, 169, 69, 0.889); border-radius:5x; float: right;">{{ $complaint->status ?? '-' }}</div>
                                                            @else
                                                                <div class="badge" style="color: rgba(208, 43, 43, 0.889); border:1px solid rgba(208, 43, 43, 0.889);  border-radius:5x; float: right;">{{ $complaint->status ?? '-' }}</div>
                                                            @endif
                                                        </span>
                                                    </a>
                                                    <a style="font-size: 12px; font-weight:100;" href="{{ url('/user-properties/complaint/show/'.$complaint->id.'/'.$up->id) }}">
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
                        <a href="{{ url('/user-properties/complaint/'.$up->id) }}" class="tf-btn accent small">+ Tambah Keluhan</a>
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
                                
                                @if ($transaction->active == 1)
                                    <br>
                                    <div class="row">
                                        <div class="col">
                                            <button  id="pay-button" class="tf-btn accent small pay-button" data-token="{{ $transaction->snaptoken }}">Bayar Sekarang</button>
                                        </div>
                                        <div class="col">
                                            <a href="#" class="tf-btn small btn-logout" style="color: red; border:1px solid red; background-color:white;" data-target="#logoutModal-{{ $transaction->id }}">Batal</a>
                                        </div>
                                        <div class="tf-panel logout" id="logoutModal-{{ $transaction->id }}">
                                            <div class="panel_overlay"></div>
                                            <div class="panel-box panel-center panel-logout">
                                                <div class="heading">
                                                    <h2 class="text-center">Anda yakin ingin membatalkan transaksi ini?</h2>
                                                </div>
                                                <div class="bottom">
                                                    <a class="clear-panel" href="#">Tidak</a>
                                                    <a class="clear-panel critical_color clickable" data-url="{{ url('/user-properties/cancel/'.$transaction->id) }}" style="cursor: pointer;">Ya</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>

    <div class="bottom-navigation-bar st2 bottom-btn-fixed" style="bottom:65px">
        <div class="tf-container">
            <div class="row">
                <div class="col">
                    <a target="_blank" href="{{ url('/user-properties/contract/'.$up->id) }}" class="tf-btn accent small">Kontrak</a>
                </div>
                @if (!$up->signature)
                    <div class="col">
                        <a style="color: rgb(255, 135, 36); border:1px solid rgb(255, 135, 36);" id="btn-popup-down" class="tf-btn small">Tanda Tangan</a>
                    </div>

                    <div class="tf-panel down">
                        <div class="panel_overlay"></div>
                        <div class="panel-box panel-down">
                            <div class="header">
                                <div class="tf-container">
                                    <div class="tf-statusbar d-flex justify-content-center align-items-center">
                                        <a href="#" class="clear-panel"> <i class="icon-close1"></i> </a>
                                        <h3>Tanda Tangan</h3>
                                    </div>

                                </div>
                            </div>

                            <div class="mt-5">
                                <div class="tf-container">
                                    <form class="tf-form" action="#" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <div class="group-input">
                                            <div style="background-color: rgb(211, 211, 211)">
                                                <div class="signature-pad-body">
                                                    <canvas id="signature-pad" class="signature-pad" width="300" height="300"></canvas>
                                                </div>
                                            </div>
                                            <div class="tf-spacing-12"></div>
                                            <button id="clear-button" class="tf-btn mt-1 float-end" style="color: rgb(197, 0, 0); border:1px solid rgb(197, 0, 0); ">Clear</button>
                                            <div class="tf-spacing-16"></div>
                                            <div class="tf-spacing-16"></div>
                                        </div>
                                        <div class="mt-7 mb-6">
                                            <button type="submit" id="save" class="tf-btn accent">Save</button>
                                        </div>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col">
                        <a style="color: rgb(255, 135, 36); border:1px solid rgb(255, 135, 36); " id="btn-popup-down" class="tf-btn small">Perpanjang</a>
                    </div>

                    <div class="tf-panel down">
                        <div class="panel_overlay"></div>
                        <div class="panel-box panel-down">
                            <div class="header">
                                <div class="tf-container">
                                    <div class="tf-statusbar d-flex justify-content-center align-items-center">
                                        <a href="#" class="clear-panel"> <i class="icon-close1"></i> </a>
                                        <h3>Perpanjang Sewa</h3>
                                    </div>

                                </div>
                            </div>

                            <div class="mt-5">
                                <div class="tf-container">
                                    <form class="tf-form" action="{{ url('/user-properties/extend/'.$up->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="group-input">
                                            <label for="period" style="z-index: 1000;">Periode Kos</label>
                                            <select style="width: 100%" name="period" id="period" class="select2 @error('period') is-invalid @enderror" onchange="calculateDate()">
                                                <option value="">-- Pilih Periode Kos --</option>
                                                @if ($room && $room->one_month_price > 0)
                                                    <option value="1" {{ old('period') == '1' ? 'selected="selected"' : '' }}>1 Bulan  - Rp {{ number_format($room->one_month_price, 0, ',', '.') }}</option>
                                                @endif
                                                @if ($room && $room->three_month_price > 0)
                                                    <option value="3" {{ old('period') == '3' ? 'selected="selected"' : '' }}>3 Bulan  - Rp {{ number_format($room->three_month_price, 0, ',', '.') }}</option>
                                                @endif
                                                @if ($room && $room->six_month_price > 0)
                                                    <option value="6" {{ old('period') == '6' ? 'selected="selected"' : '' }}>6 Bulan  - Rp {{ number_format($room->six_month_price, 0, ',', '.') }}</option>
                                                @endif
                                                @if ($room && $room->twelve_month_price > 0)
                                                    <option value="12" {{ old('period') == '12' ? 'selected="selected"' : '' }}>12 Bulan  - Rp {{ number_format($room->twelve_month_price, 0, ',', '.') }}</option>
                                                @endif
                                            </select>
                                            @error('period')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="group-input">
                                            <label for="start_date">Tanggal Mulai Sewa</label>
                                            <input type="date" class="@error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date', $up_start_date) }}" placeholder="yyyy-mm-dd" onchange="calculateDate()">
                                            @error('start_date')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="group-input">
                                            <label for="end_date">Tanggal Selesai Sewa</label>
                                            <input type="date" class="@error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date') }}" placeholder="yyyy-mm-dd">
                                            @error('end_date')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        

                                        <div class="mt-7 mb-6">
                                            <button type="submit" id="save" class="tf-btn accent">Save</button>
                                        </div>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
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
            document.querySelectorAll('.pay-button').forEach(function (btn) {
                btn.addEventListener('click', function () {

                    const snapToken = this.dataset.token;

                    window.snap.pay(snapToken, {
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
                    });

                });
            });

            $('.select2').select2();

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

            flatpickr("#start_date", {
                clickOpens: false,
                disableMobile: true
            });

            flatpickr("#end_date", {
                clickOpens: false,
                disableMobile: true
            });

            var canvas = document.querySelector('canvas');
            if (canvas) {
                var signaturePad = new SignaturePad(canvas, {
                    minWidth: 2.5,
                    maxWidth: 5.5
                });
                
                $('#save').on('click', function (e) {
                    $('#save').prop('disabled', true);
                    e.preventDefault();
                    var signature = signaturePad.toDataURL();
    
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: "{{ url('/user-properties/signature/'.$up->id) }}",
                        data: {signature : signature},
                        success: function (response) {
                            sessionStorage.setItem("success", "Data Has Been Updated");
                            window.location.href = "{{ url('/user-properties/show/'.$up->id) }}";
                        },
                        error: function (xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Gagal',
                            });
                        }
                    });
                });
    
                $('#clear-button').on('click', function (e) {
                    e.preventDefault();
                    signaturePad.clear();
                });
            }

            function calculateDate() {
                var startDateStr = $('#start_date').val();
                var period = parseInt($('#period').val());

                if (startDateStr && !isNaN(period)) {
                    var startDate = new Date(startDateStr);
                    startDate.setMonth(startDate.getMonth() + period);

                    var year = startDate.getFullYear();
                    var month = ('0' + (startDate.getMonth() + 1)).slice(-2);
                    var day = ('0' + startDate.getDate()).slice(-2);

                    var endDateStr = year + '-' + month + '-' + day;
                    $('#end_date').val(endDateStr);
                } else {
                    $('#end_date').val('');
                }
            };

            Carousel(document.getElementById("myCarousel"), {
            }, {
                Lazyload,
                Arrows,
                Thumbs
            }).init();

            Fancybox.bind("[data-fancybox]", {
            });

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
