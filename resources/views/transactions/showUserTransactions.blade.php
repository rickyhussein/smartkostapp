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

@endsection
