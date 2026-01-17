@extends('layouts.app')
@section('back')
    <a href="{{ url('/user-properties') }}" class="back-btn"> <i class="icon-left"></i> </a>
@endsection
@section('container')
    <div id="app-wrap">
        <div class="bill-content">
            <div class="app-section bg_white_color giftcard-detail-section-1">
                <div class="tf-container">
                    <div class="voucher-desc">
                        <a href="{{ url('/properties/user/show/'.$up->property_id) }}" class="row">
                            <div class="col-4">
                                <img src="{{ url('/storage/'.$up->property->photos->first()->property_file_path) }}" alt="image" style="max-height: 70px; border-radius:10px;">
                            </div>
                            <div class="col-8">
                                <div class="badge me-2" style="color: gray; border:1px solid gray; background-color:white;"><i class="fa fa-home me-1"></i>{{ $up->property->category ?? '-' }}</div>
                                <br>
                                {{ $up->property && $up->property->name ? ucwords(strtolower($up->property->name)) : '' }} {{ $up->property && $up->property->village && $up->property->village->name ? ucwords(strtolower($up->property->village->name)) : '' }}
                                <br>
                                {{ $up->property && $up->property->district && $up->property->district->name ? ucwords(strtolower($up->property->district->name)) : '' }} - {{ $up->property && $up->property->city && $up->property->city->name ? ucwords(strtolower($up->property->city->name)) : '' }}
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
                            </div>
                        </a>
                    </div>
                    <hr style="color: rgb(180, 180, 180)">
                    
                    <div class="voucher-desc">
                        <a href="{{ url('/properties/user/room/show/'.$up->room_id.'/'.$up->property_id) }}" class="row">
                            <div class="col-4">
                                <img src="{{ url('/storage/'.$up->room->room_file_path) }}" alt="image" style="max-height: 70px; border-radius:10px;">
                            </div>
                            <div class="col-8">
                                <div class="badge me-2" style="color: gray; border:1px solid gray; background-color:white; "><i class="far fa-square me-1"></i>{{ $up->room->room_height ?? '-' }} x {{ $up->room->room_width ?? '-' }} Meter</div>
                                <br>
                                Kamar {{ $up->room->room_name ?? '-' }} {{ $up->room->room_type ? '- Tipe ' . $up->room->room_type : '' }} {{ $up->room->floor ? '- Lantai ' . $up->room->floor : '' }}
                                <br>
                                @if ($up->status == 'Menunggu Persetujuan Owner')
                                    <div class="badge me-1" style="color: rgb(21, 47, 118); border:1px solid rgb(21, 47, 118); background-color:rgba(210, 229, 255, 0.889); border-radius:5x;">{{ $up->status ?? '-' }}</div>
                                @elseif($up->status == 'Pembayaran Berhasil')
                                    <div class="badge me-1" style="color: rgba(20, 78, 7, 0.889); border:1px solid rgba(20, 78, 7, 0.889); background-color:rgb(208, 255, 187); border-radius:5x;">{{ $up->status ?? '-' }}</div>
                                @elseif($up->status == 'Menunggu Pembayaran')
                                    <div class="badge me-1" style="color: rgb(255, 135, 36); border:1px solid rgb(255, 135, 36); background-color:rgba(255, 233, 197, 0.889); border-radius:5x;">{{ $up->status ?? '-' }}</div>
                                @else
                                    <div class="badge me-1" style="color: rgba(78, 26, 26, 0.889); border:1px solid rgba(78, 26, 26, 0.889); background-color:rgb(255, 209, 209); border-radius:5x;">{{ $up->status ?? '-' }}</div>
                                @endif
                            </div>
                        </a>
                    </div>
                    <hr style="color: rgb(180, 180, 180)">

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
                                <a href="{{ url('/storage/'.$up->rent->ktp_photo_transaction) }}" target="_blank" class="image-preview-container" id="roomImage">
                                    <img src="{{ url('/storage/'.$up->rent->ktp_photo_transaction) }}" alt="img-preview" class="img-preview" style="max-width: 80px; max-height: 80px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
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
                                <a href="{{ url('/storage/'.$up->rent->kk_photo_transaction) }}" target="_blank" class="image-preview-container" id="roomImage">
                                    <img src="{{ url('/storage/'.$up->rent->kk_photo_transaction) }}" alt="img-preview" class="img-preview" style="max-width: 80px; max-height: 80px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
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
        <style>
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
        
    @endpush
@endsection
