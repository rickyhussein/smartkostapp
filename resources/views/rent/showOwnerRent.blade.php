@extends('layouts.appowner')
@section('back')
    <a href="{{ url('/rent/owner') }}" class="back-btn"> <i class="icon-left"></i> </a>
@endsection
@section('container')
    <div id="app-wrap">
        <div class="bill-content">
            <div class="app-section bg_white_color giftcard-detail-section-1">
                <div class="tf-container">
                    <div class="voucher-desc">
                        <a href="{{ url('/property/owner/show/'.$rent->property_id) }}" class="row">
                            <div class="col-4">
                                <img src="{{ url('/storage/'.$rent->property->photos->first()->property_file_path) }}" alt="image" style="max-height: 70px; border-radius:10px;">
                            </div>
                            <div class="col-8">
                                <div class="badge me-2" style="color: gray; border:1px solid gray; background-color:white;"><i class="fa fa-home me-1"></i>{{ $rent->property->category ?? '-' }}</div>
                                <br>
                                {{ $rent->property && $rent->property->name ? ucwords(strtolower($rent->property->name)) : '' }} {{ $rent->property && $rent->property->village && $rent->property->village->name ? ucwords(strtolower($rent->property->village->name)) : '' }}
                                <br>
                                {{ $rent->property && $rent->property->district && $rent->property->district->name ? ucwords(strtolower($rent->property->district->name)) : '' }} - {{ $rent->property && $rent->property->city && $rent->property->city->name ? ucwords(strtolower($rent->property->city->name)) : '' }}
                                <br>
                                @php
                                    $facility = '';
                                @endphp
                                @if ($rent->property && count($rent->property->facilities) > 0)
                                    @foreach ($rent->property->facilities as $pf)
                                        @php
                                            $pemisah = !$loop->last ? ', ' : '';
                                            $facility .= $pf->facility->name . $pemisah;
                                        @endphp
                                    @endforeach
                                @endif
                                <span style="color: rgb(169, 169, 169)">{{ Str::limit($facility, 32, '...') }}</span>
                                <br>
                                @if ($rent->status == 'Menunggu Persetujuan Owner')
                                    <div class="badge" style="color: rgb(21, 47, 118); border:1px solid rgb(21, 47, 118); background-color:rgba(210, 229, 255, 0.889); border-radius:5x;">{{ $rent->status ?? '-' }}</div>
                                @elseif($rent->status == 'Disetujui')
                                    <div class="badge" style="color: rgba(20, 78, 7, 0.889); border:1px solid rgba(20, 78, 7, 0.889); background-color:rgb(208, 255, 187); border-radius:5x;">{{ $rent->status ?? '-' }}</div>
                                @else
                                    <div class="badge" style="color: rgba(78, 26, 26, 0.889); border:1px solid rgba(78, 26, 26, 0.889); background-color:rgb(255, 209, 209); border-radius:5x;">{{ $rent->status ?? '-' }}</div>
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
                        <span style="color: rgb(169, 169, 169)">{{ $rent->user->name ?? '-' }}</span>
                        <br>
                        <br>
                        <span style="color: black">Nomor HP</span>
                        <br>
                        <span style="color: rgb(169, 169, 169)">{{ $rent->user->phone_number ?? '-' }}</span>
                        <br>
                        <br>
                        <span style="color: black">Jenis Kelamin</span>
                        <br>
                        <span style="color: rgb(169, 169, 169)">{{ $rent->user->gender ?? '-' }}</span>
                        <br>
                        <br>
                        <span style="color: black">Pekerjaan</span>
                        <br>
                        <span style="color: rgb(169, 169, 169)">{{ $rent->user->job ?? '-' }}</span>
                        <br>
                        <br>
                        <span style="color: black">Nama Kampus / Kantor</span>
                        <br>
                        <span style="color: rgb(169, 169, 169)">{{ $rent->user->job_desc ?? '-' }}</span>
                        <br>
                        <br>
                        <div style="float:right;">
                            <a href="{{ url('/storage/'.$rent->room->room_file_path) }}" target="_blank" class="image-preview-container mb-8" id="roomImage">
                                <img src="{{ url('/storage/'.$rent->room->room_file_path) }}" alt="img-preview" class="img-preview" style="max-width: 80px; height: auto; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                            </a>
                        </div>
                        <br>
                        <span style="color: black">
                            Nama / Nomor Kamar
                        </span>
                        <br>
                        <span style="color: rgb(169, 169, 169)">
                            Kamar {{ $rent->room->room_name ?? '-' }} {{ $rent->room->room_type ? '- Tipe ' . $rent->room->room_type : '' }} {{ $rent->room->floor ? '- Lantai ' . $rent->room->floor : '' }}
                        </span>
                        <br>
                        <br>
                        <br>
                        <span style="color: black">
                            Ukuran Kamar
                        </span>
                        <br>
                        <span style="color: rgb(169, 169, 169)">
                            {{ $rent->room->room_height ?? '-' }} x {{ $rent->room->room_width ?? '-' }} Meter
                        </span>
                        <br>
                        <br>
                        <span style="color: black">Periode Kos</span>
                        <br>
                        <span style="color: rgb(169, 169, 169)">{{ $rent->period }} Bulan</span>
                        <br>
                        <br>
                        <span style="color: black">Tanggal Mulai Sewa</span>
                        <br>
                        <span style="color: rgb(169, 169, 169)">
                            @php
                                if ($rent->start_date) {
                                    Carbon\Carbon::setLocale('id');
                                    $start_date = Carbon\Carbon::createFromFormat('Y-m-d', $rent->start_date);
                                    $new_start_date = $start_date->translatedFormat('d F Y');
                                } else {
                                    $new_start_date = '-';
                                }
                            @endphp
                            {{ $new_start_date  }}
                        </span>
                        <br>
                        <br>
                        <span style="color: black">Tanggal Selesai Sewa</span>
                        <br>
                        <span style="color: rgb(169, 169, 169)">
                            @php
                                if ($rent->end_date) {
                                    Carbon\Carbon::setLocale('id');
                                    $end_date = Carbon\Carbon::createFromFormat('Y-m-d', $rent->end_date);
                                    $new_end_date = $end_date->translatedFormat('d F Y');
                                } else {
                                    $new_end_date = '-';
                                }
                            @endphp
                            {{ $new_end_date  }}
                        </span>
                        <br>
                        <br>
                        <span style="color: black">Catatan</span>
                        <br>
                        {!! $rent->note ? nl2br(e($rent->note)) : '-' !!}
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
                    <hr style="color: rgb(180, 180, 180)">

                    <div class="voucher-desc">
                        <h4 class="fw_6">Rincian Pembayaran</h4>
                        <br>
                        <span style="float: left">Biaya sewa</span>
                        <h6 id="textAmount" style="float: right">Rp {{ number_format($rent->amount) }}</h6>
                        <br>
                        <span style="float: left">Biaya Deposit</span>
                        <h6 id="textDeposit" style="float: right">Rp {{ number_format($rent->deposit_price) }}</h6>
                        <br>
                    </div>
                    <hr style="color: rgb(180, 180, 180)">

                    <div class="voucher-desc">
                        <h3 style="float: left">Total Pembayaran Pertama</h3>
                        <h3 id="textTotalAmount" style="float: right">Rp {{ number_format($rent->total_amount) }}</h3>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @if ($rent->status == 'Menunggu Persetujuan Owner')
        <div class="bottom-navigation-bar st2 bottom-btn-fixed" style="bottom:65px">
            <div class="tf-container">
                <a style="color: rgb(255, 135, 36); border:1px solid rgb(255, 135, 36); " id="btn-popup-down" class="tf-btn large" disabled>Approval</a>
            </div>
        </div>
    @endif

    <div class="tf-panel down">
        <div class="panel_overlay"></div>
        <div class="panel-box panel-down">
            <div class="header">
                <div class="tf-container">
                    <div class="tf-statusbar d-flex justify-content-center align-items-center">
                        <a href="#" class="clear-panel"> <i class="icon-close1"></i> </a>
                        <h3>Approval</h3>
                    </div>

                </div>
            </div>

            <div class="mt-5">
                <div class="tf-container">
                    <form class="tf-form" action="{{ url('/rent/owner/approval/'.$rent->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="group-input">
                            <label for="status" style="z-index: 1000;">Status</label>
                            <select style="width: 100%" name="status" id="status" class="select2 @error('status') is-invalid @enderror">
                                <option value="">-- Pilih Status --</option>
                                <option value="Setuju" {{ 'Setuju' == old('status') ? 'selected="selected"' : '' }}>Setuju</option>
                                <option value="Tolak" {{ 'Tolak' == old('status') ? 'selected="selected"' : '' }}>Tolak</option>
                            </select>
                            @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="group-input">
                            <label for="owner_note">Catatan</label>
                            <textarea name="owner_note" id="owner_note" class="@error('owner_note') is-invalid @enderror" cols="30" rows="5">{{ old('owner_note') }}</textarea>
                            @error('owner_note')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mt-7 mb-6">
                            <button type="submit" class="tf-btn accent">Submit</button>
                        </div>
                </form>
                </div>
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
        <style>
            .file-input-wrapper {
                position: relative;
                height: calc(2.25rem + 2px);
                margin-bottom: 10px;
            }
            .file-name-display {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                padding: 0.375rem 0.75rem;
                background-color: #f8f9fa;
                border: 1px solid #ced4da;
                border-radius: 0.25rem;
                pointer-events: none;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
                height: calc(2.25rem + 2px);
                line-height: 1.5;
            }
            input[type="file"] {
                opacity: 0;
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                cursor: pointer;
                z-index: 1;
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
        <script>

        </script>
    @endpush
@endsection
