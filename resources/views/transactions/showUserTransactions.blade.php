@extends('layouts.app')
@section('back')
    <a href="{{ url('/transactions/user') }}" class="back-btn"> <i class="icon-left"></i> </a>
@endsection
@section('container')

    <div id="app-wrap">
        <div class="bill-payment-content">
            <div class="tf-container">
                 <div class="wrapper-bill">
                     <div class="archive-top">
                         @if ($transaction->status == 'paid')
                            @php
                                $color = 'green';
                            @endphp
                            <img src="{{ url('/assets/img/success.png') }}" style="width: 60px; height: 60px; border-radius: 100px; object-fit: cover;">
                         @elseif ($transaction->status == 'unpaid')
                            @php
                                $color = 'orange';
                            @endphp
                            <img src="{{ url('/assets/img/pending.png') }}" style="width: 60px; height: 60px; border-radius: 100px; object-fit: cover;">
                         @else
                            @php
                                $color = 'red';
                            @endphp
                            <img src="{{ url('/assets/img/failed.png') }}" style="width: 80px; height: 80px; border-radius: 100px; object-fit: cover;">
                         @endif
                         <h1><a href="#" style="color:{{ $color }}">IDR {{ number_format($transaction->total_amount) }}</a></h1>
                         <h3 class="mt-2 fw_6">Pembayaran {{ $transaction->property && $transaction->property->name ? ucwords(strtolower($transaction->property->name)) : '' }} - Kamar {{ $transaction->room && $transaction->room->room_name ? ucwords(strtolower($transaction->room->room_name)) : '' }}</h3>
                         <p class="fw_4 mt-2">
                            @php
                                if ($transaction->status == 'paid') {
                                    $status = 'Berhasil';
                                } else if ($transaction->status == 'unpaid') {
                                    $status = 'Menunggu Pembayaran';
                                } else if ($transaction->status == 'deny') {
                                    $status = 'Ditolak';
                                } else if ($transaction->status == 'cancel') {
                                    $status = 'Dibatalkan';
                                } else if ($transaction->status == 'expire') {
                                    $status = 'Kadaluarsa';
                                } else {
                                    $status = 'Gagal';
                                }
                            @endphp
                            @if ($transaction->status == 'unpaid')
                                <p>Menunggu Pembayaran Dari Anda</p>
                            @else
                                <p>Pembayaran Anda Telah {{ $status }}</p>
                            @endif
                         </p>
                     </div>
                     <div class="dashed-line"></div>
                     <div class="archive-bottom">
                         <h2 class="text-center">Informasi Transaksi</h2>
                         <ul>
                            <li class="list-info-bill">
                                Nama User
                                <span>
                                    {{ $transaction->user->name ?? '-'  }}
                                </span> 
                            </li>
                            <li class="list-info-bill">
                                Tanggal Mulai Sewa 
                                <span>
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
                            </li>
                            <li class="list-info-bill">
                                Tanggal Selesai Sewa 
                                <span>
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
                            </li>
                            <li class="list-info-bill">
                                Periode Sewa 
                                <span>
                                    {{ $transaction->period ?? '-' }} Bulan
                                </span> 
                            </li>
                            <li class="list-info-bill">
                                Biaya Sewa Kos
                                <span>
                                    Rp {{ number_format($transaction->amount) }}
                                </span> 
                            </li>
                            <li class="list-info-bill">
                                Biaya Deposit 
                                <span>
                                    Rp {{ number_format($transaction->deposit_price) }}
                                </span> 
                            </li>
                            <li class="list-info-bill">
                                Total Pembayaran 
                                <span>
                                    Rp {{ number_format($transaction->total_amount) }}
                                </span> 
                            </li>
                         </ul>
                     </div>
                 </div>
            </div>
         </div>
    </div>
    
    <br>
    <br>
    <br>
    <br>
    <br>

    @if ($transaction->status == 'unpaid')
        <div class="bottom-navigation-bar st1 bottom-btn-fixed" style="bottom:65px">
            <div class="tf-container">
                <button  id="pay-button" class="tf-btn accent large">Bayar Sekarang</button>
            </div>
        </div>

        @push('style')
            <script type="text/javascript" src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
        @endpush

        @push('script')
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

@endsection
