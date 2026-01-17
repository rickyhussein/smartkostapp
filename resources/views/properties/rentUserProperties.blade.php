@extends('layouts.app')
@section('back')
    <a href="{{ url('/properties/user/show/'.$property->id) }}" class="back-btn"> <i class="icon-left"></i> </a>
@endsection
@section('container')
    <form class="tf-form" action="{{ url('/properties/user/rents/store/'.$property->id) }}" enctype="multipart/form-data" method="POST">
        @csrf
        <div id="app-wrap">
            <div class="bill-content">
                <div class="app-section bg_white_color giftcard-detail-section-1">
                    <div class="tf-container">
                        <div class="voucher-desc">
                            <div class="row">
                                <div class="col-4">
                                    <img src="{{ url('/storage/'.$property->photos->first()->property_file_path) }}" alt="image" style="max-height: 70px; border-radius:10px;">
                                </div>
                                <div class="col-8">
                                    <div class="badge me-2" style="color: gray; border:1px solid gray; background-color:white;"><i class="fas fa-home me-1"></i>{{ $property->category ?? '-' }}</div>
                                    <br>
                                    {{ $property->name ? ucwords(strtolower($property->name)) : '' }} {{ $property->village->name ? ucwords(strtolower($property->village->name)) : '' }}
                                    <h6>{{ $property->district->name ? ucwords(strtolower($property->district->name)) : '' }} - {{ $property->city->name ? ucwords(strtolower($property->city->name)) : '' }}</h6>
                                    @php
                                        $facility = '';
                                    @endphp
                                    @foreach ($property->facilities as $pf)
                                        @php
                                            $pemisah = !$loop->last ? ', ' : '';
                                            $facility .= $pf->facility->name . $pemisah;
                                        @endphp
                                    @endforeach
                                    <span style="color: rgb(169, 169, 169)">{{ Str::limit($facility, 32, '...') }}</span>
                                </div>
                            </div>
                        </div>
                        <hr style="color: rgb(180, 180, 180)">

                        <div class="voucher-desc">
                            <h4 class="fw_6">Informasi Penyewa</h4>
                            <br>
                            <span>Nama Penyewa</span>
                            <br>
                            <span style="color: rgb(169, 169, 169)">{{ auth()->user()->name }}</span>
                            <br>
                            <br>
                            <span>Nomor HP</span>
                            <br>
                            <span style="color: rgb(169, 169, 169)">{{ auth()->user()->phone_number }}</span>
                            <br>
                            <br>
                            <span>Jenis Kelamin</span>
                            <br>
                            <span style="color: rgb(169, 169, 169)">{{ auth()->user()->gender }}</span>
                            <br>
                            <br>
                            <span>Pekerjaan</span>
                            <br>
                            <span style="color: rgb(169, 169, 169)">{{ auth()->user()->job }}</span>
                            <br>
                            <br>
                            <span>Nama Kampus / Kantor</span>
                            <br>
                            <span style="color: rgb(169, 169, 169)">{{ auth()->user()->job_desc }}</span>
                        </div>
                        <hr style="color: rgb(180, 180, 180)">

                        <div class="voucher-desc">
                            <h4 class="fw_6">Formulir Penyewa</h4>
                            <div class="tf-spacing-20"></div>

                            <div class="group-input">
                                <label for="room_id" style="z-index: 1000;">Pilih Kamar</label>
                                <select style="width: 100%" name="room_id" id="room_id" class="select2 @error('room_id') is-invalid @enderror">
                                    <option value="">-- Pilih Kamar --</option>
                                    @foreach ($property->roomAvailable($property->id) as $ra)
                                        <option value="{{ $ra->id }}" {{ $ra->id == old('room_id', request('room_id')) ? 'selected="selected"' : '' }}>Kamar {{ $ra->room_name ?? '-' }} {{ $ra->room_type ? '- Tipe ' . $ra->room_type : '' }}</option>
                                    @endforeach
                                </select>
                                @error('room_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div id="roomContainer">
                                @if ($room)
                                    <a href="{{ url('/properties/user/room/show/'.$room->id.'/'.$property->id) }}" target="_blank" style="color: black; text-decoration: none;">
                                        <div class="card mt-4" style="border-radius: 15px; width: 100%;">
                                            <img style="max-height: 150px; border-top-left-radius: 15px; border-top-right-radius: 15px; width: 100%; object-fit: cover;" src="{{ url('/storage/'.$room->room_file_path) }}" class="card-img-top" alt="">
                                            <div class="card-body">
                                                <h5 class="card-title">Kamar {{ $room->room_name ? ucwords(strtolower($room->room_name)) : '' }} Tipe {{ $room->room_type ? ucwords(strtolower($room->room_type)) : '' }}</h5>
                                                <div class="badge me-2" style="color: gray; border:1px solid gray; background-color:white; font-size:8px"><i class="fas fa-home me-1"></i>Lantai {{ $room->floor ?? '-' }}</div>
                                                <div class="badge me-2" style="color: gray; border:1px solid gray; background-color:white; font-size:8px"><i class="far fa-square me-1"></i>{{ $room->room_height ?? '-' }} x {{ $room->room_width ?? '-' }} Meter</div>
                                                <br>
                                                <div style="font-size: 8px;">
                                                    <span style="float: left;">Harga 1 Bulan</span>
                                                    <span style="float: right;" class="critical_color">Rp {{ number_format($room->one_month_price) }}</span>
                                                </div>
                                                <br>
                                                @if ($room->three_month_price > 0)
                                                    <div style="font-size: 8px;">
                                                        <span style="float: left;">Harga 3 Bulan</span>
                                                        <span style="float: right;" class="critical_color">Rp {{ number_format($room->three_month_price) }}</span>
                                                    </div>
                                                    <br>
                                                @endif
                                                @if ($room->six_month_price > 0)
                                                    <div style="font-size: 8px;">
                                                        <span style="float: left;">Harga 6 Bulan</span>
                                                        <span style="float: right;" class="critical_color">Rp {{ number_format($room->six_month_price) }}</span>
                                                    </div>
                                                    <br>
                                                @endif
                                                @if ($room->twelve_month_price > 0)
                                                    <div style="font-size: 8px;">
                                                        <span style="float: left;">Harga 12 Bulan</span>
                                                        <span style="float: right;" class="critical_color">Rp {{ number_format($room->twelve_month_price) }}</span>
                                                    </div>
                                                    <br>
                                                @endif
                                                @if ($room->deposit_price > 0)
                                                    <div style="font-size: 8px;">
                                                        <span style="float: left;">Biaya Deposit</span>
                                                        <span style="float: right;" class="critical_color">Rp {{ number_format($room->deposit_price) }}</span>
                                                    </div>
                                                    <br>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                    <br>
                                @endif
                            </div>

                            <div class="group-input">
                                <label for="period" style="z-index: 1000;">Periode Kos</label>
                                <select style="width: 100%" name="period" id="period" class="select2 @error('period') is-invalid @enderror">
                                    <option value="">-- Pilih Periode Kos --</option>
                                    @if ($one_month_price > 0)
                                        <option value="1" {{ old('period') == '1' ? 'selected="selected"' : '' }}>1 Bulan  - Rp {{ number_format($one_month_price, 0, ',', '.') }}</option>
                                    @endif
                                    @if ($three_month_price > 0)
                                        <option value="3" {{ old('period') == '3' ? 'selected="selected"' : '' }}>3 Bulan  - Rp {{ number_format($three_month_price, 0, ',', '.') }}</option>
                                    @endif
                                    @if ($six_month_price > 0)
                                        <option value="6" {{ old('period') == '6' ? 'selected="selected"' : '' }}>6 Bulan  - Rp {{ number_format($six_month_price, 0, ',', '.') }}</option>
                                    @endif
                                    @if ($twelve_month_price > 0)
                                        <option value="12" {{ old('period') == '12' ? 'selected="selected"' : '' }}>12 Bulan  - Rp {{ number_format($twelve_month_price, 0, ',', '.') }}</option>
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
                                <input type="date" class="@error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date') }}" placeholder="yyyy-mm-dd" onchange="calculateDate()">
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

                            <div class="group-input">
                                <label for="note">Catatan</label>
                                <textarea name="note" id="note" class="@error('note') is-invalid @enderror" cols="30" rows="5" style="resize: vertical;" onblur="this.style.boxShadow='none'">{{ old('note') }}</textarea>
                                @error('note')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <label for="ktp_photo_transaction" style="display:block; margin-top:-15px;">Foto KTP</label>
                            <div class="group-input">
                                <div class="file-input-wrapper">
                                    <input class="form-control" type="file" id="ktp_photo_transaction" name="ktp_photo_transaction" accept="image/*">
                                    <div class="file-name-display">
                                        <span class="ktp_display">{{ auth()->user()->ktp_photo ? basename(auth()->user()->ktp_photo) : 'Belum ada file dipilih' }}</span>
                                    </div>
                                </div>
                                @error('ktp_photo_transaction')
                                <div style="color: red; font-size: 10px;">
                                    {{ $message }}
                                </div>
                                @enderror
                                @if (auth()->user()->ktp_photo)
                                    <div class="image-preview-container mt-2">
                                        <a href="{{ url('storage/'.auth()->user()->ktp_photo) }}">
                                            <img src="{{ asset('storage/'.auth()->user()->ktp_photo) }}" alt="Preview Foto" style="max-width: 200px; max-height: 200px;">
                                        </a>
                                    </div>
                                @endif
                            </div>

                            <label for="kk_photo_transaction" style="display:block; margin-top:-15px;">Foto Kartu Keluarga</label>
                            <div class="group-input">
                                <div class="file-input-wrapper">
                                    <input class="form-control" type="file" id="kk_photo_transaction" name="kk_photo_transaction" accept="image/*">
                                    <div class="file-name-display">
                                        <span class="kk_display">{{ auth()->user()->kk_photo ? basename(auth()->user()->kk_photo) : 'Belum ada file dipilih' }}</span>
                                    </div>
                                </div>
                                @error('kk_photo_transaction')
                                <div style="color: red; font-size: 10px;">
                                    {{ $message }}
                                </div>
                                @enderror
                                @if (auth()->user()->kk_photo)
                                    <div class="image-preview-container mt-2">
                                        <a href="{{ url('storage/'.auth()->user()->kk_photo) }}">
                                            <img src="{{ asset('storage/'.auth()->user()->kk_photo) }}" alt="Preview Foto" style="max-width: 200px; max-height: 200px;">
                                        </a>
                                    </div>
                                @endif
                            </div>

                            <input type="hidden" name="kk_photo" id="kk_photo" class="kk_photo" value="{{ old('kk_photo', auth()->user()->kk_photo) }}">
                            <input type="hidden" name="ktp_photo" id="ktp_photo" class="ktp_photo" value="{{ old('ktp_photo', auth()->user()->ktp_photo) }}">

                        </div>
                        <hr style="color: rgb(180, 180, 180)">

                        <div class="voucher-desc">
                            <h4 class="fw_6">Rincian Pembayaran</h4>
                            <br>
                            <span style="float: left">Biaya sewa</span>
                            <h6 id="textAmount" style="float: right">Rp {{ old('amount', '0') }}</h6>
                            <br>
                            <span style="float: left">Biaya Deposit</span>
                            <h6 id="textDeposit" style="float: right">Rp {{ old('deposit_price', '0') }}</h6>
                            <br>
                        </div>
                        <hr style="color: rgb(180, 180, 180)">

                        <div class="voucher-desc">
                            <h3 style="float: left">Total Pembayaran Pertama</h3>
                            <h3 id="textTotalAmount" style="float: right">Rp {{ old('total_amount', '0') }}</h3>
                        </div>

                        <input type="hidden" name="user_id" id="user_id" class="user_id" value="{{ old('user_id', auth()->user()->id) }}">
                        <input type="hidden" name="property_id" id="property_id" class="property_id" value="{{ old('property_id', $property->id) }}">
                        <input type="hidden" name="amount" id="amount" class="amount" value="{{ old('amount') }}">
                        <input type="hidden" name="deposit_price" id="deposit_price" class="deposit_price" value="{{ old('deposit_price') }}">
                        <input type="hidden" name="total_amount" id="total_amount" class="total_amount" value="{{ old('total_amount') }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="bottom-navigation-bar st2 bottom-btn-fixed" style="bottom:65px">
            <div class="tf-container">
                <button type="submit" class="tf-btn small" style="color: green; border:1px solid green; background-color:white;">Ajukan Sewa</button>
            </div>
        </div>
    </form>

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
                background-color: #ffffff;
                border: 1px solid #acacac;
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
                border: 1px dashed #acacac;
                border-radius: 4px;
                display: inline-block;
            }
        </style>
    @endpush

    @push('script')
        <script>
            $('.select2').select2();

            flatpickr("#start_date", {
                disableMobile: true
            });

            flatpickr("#end_date", {
                clickOpens: false,
                disableMobile: true
            });
            
            function ucwords(str) { 
                return str .toLowerCase() .replace(/\b\w/g, char => char.toUpperCase()); 
            }

            $('body').on('change', '#room_id', function(event) {
                $('#roomContainer').empty();
                var room_id = parseInt($('#room_id').val());
                $('#period').empty();
                $('#period').append('<option value="">-- Pilih Periode Kos --</option>');
                $('#amount').val(0);
                $('#textAmount').text('Rp 0');
                $('#deposit_price').val(0);
                $('#textDeposit').text('Rp 0');
                $('#total_amount').val(0);
                $('#textTotalAmount').text('Rp 0');
                $('#end_date').val('');

                $.ajax({
                    type: 'GET',
                    url: "{{ url('/get-room') }}",
                    data: {room_id: room_id},
                    success: function(data) {
                        let room = `
                            <a href="{{ url('/properties/user/room/show/${data.id}/${data.property_id}') }}" target="_blank" style="color: black; text-decoration: none;">
                                <div class="card mt-4" style="border-radius: 15px; width: 100%;">
                                    <img style="max-height: 150px; border-top-left-radius: 15px; border-top-right-radius: 15px; width: 100%; object-fit: cover;" src="{{ url('/storage/${data.room_file_path}') }}" class="card-img-top" alt="">
                                    <div class="card-body">
                                        <h5 class="card-title">Kamar ${data.room_name ? ucwords(data.room_name) : '-'} Tipe ${data.room_type ? ucwords(data.room_type) : '-'}</h5>
                                        <div class="badge me-2" style="color: gray; border:1px solid gray; background-color:white; font-size:8px"><i class="fas fa-home me-1"></i>Lantai ${data.floor}</div>
                                        <div class="badge me-2" style="color: gray; border:1px solid gray; background-color:white; font-size:8px"><i class="far fa-square me-1"></i>${data.room_height} x ${data.room_width} Meter</div>
                                        <br>
                                        <div style="font-size: 8px;">
                                            <span style="float: left;">Harga 1 Bulan</span>
                                            <span style="float: right;" class="critical_color">Rp ${accounting.formatMoney(data.one_month_price, '', 0, ",", ".")}</span>
                                        </div>
                                        <br>
                                        ${data.three_month_price > 0 ? `
                                            <div style="font-size: 8px;">
                                                <span style="float: left;">Harga 3 Bulan</span>
                                                <span style="float: right;" class="critical_color">Rp ${accounting.formatMoney(data.three_month_price, '', 0, ",", ".")}</span>
                                            </div>
                                            <br>
                                        ` : ''}
                                        ${data.six_month_price > 0 ? `
                                            <div style="font-size: 8px;">
                                                <span style="float: left;">Harga 6 Bulan</span>
                                                <span style="float: right;" class="critical_color">Rp ${accounting.formatMoney(data.six_month_price, '', 0, ",", ".")}</span>
                                            </div>
                                            <br>
                                        ` : ''}
                                        ${data.twelve_month_price > 0 ? `
                                            <div style="font-size: 8px;">
                                                <span style="float: left;">Harga 12 Bulan</span>
                                                <span style="float: right;" class="critical_color">Rp ${accounting.formatMoney(data.twelve_month_price, '', 0, ",", ".")}</span>
                                            </div>
                                            <br>
                                        ` : ''}
                                        ${data.deposit_price > 0 ? `
                                            <div style="font-size: 8px;">
                                                <span style="float: left;">Biaya Deposit</span>
                                                <span style="float: right;" class="critical_color">Rp ${accounting.formatMoney(data.deposit_price, '', 0, ",", ".")}</span>
                                            </div>
                                            <br>
                                        ` : ''}
                                    </div>
                                </div>
                            </a>
                            <br>
                        `;

                        $('#roomContainer').append(room);

                        $('#period').append('<option value="1">1 Bulan  - Rp ' + accounting.formatMoney(data.one_month_price, '', 0, ",", ".") + '</option>');
                        if (data.three_month_price > 0) {
                            $('#period').append('<option value="3">3 Bulan  - Rp ' + accounting.formatMoney(data.three_month_price, '', 0, ",", ".") + '</option>');
                        }
                        if (data.six_month_price > 0) {
                            $('#period').append('<option value="6">6 Bulan  - Rp ' + accounting.formatMoney(data.six_month_price, '', 0, ",", ".") + '</option>');
                        }
                        if (data.twelve_month_price > 0) {
                            $('#period').append('<option value="12">12 Bulan  - Rp ' + accounting.formatMoney(data.twelve_month_price, '', 0, ",", ".") + '</option>');
                        }
                    }
                });
            });

            $('body').on('change', '#period', function(event) {
                var period = parseInt($('#period').val());
                var room_id = $('#room_id').val();
                $.ajax({
                    type:'GET',
                    url:"{{ url('/get-room') }}",
                    data:{room_id:room_id},
                    success:function(data){
                        if (!isNaN(period)) {
                            if (period == 1) {
                                var price = data.one_month_price;
                            } else if (period == 3) {
                                var price = data.three_month_price;
                            } else if (period == 6) {
                                var price = data.six_month_price;
                            } else {
                                var price = data.twelve_month_price;
                            }
                            $('#amount').val(price);
                            $('#textAmount').text('Rp ' + accounting.formatMoney(price, '', 0, ",", "."));
                            var deposit_price = data.deposit_price;
                            $('#deposit_price').val(deposit_price);
                            $('#textDeposit').text('Rp ' + accounting.formatMoney(deposit_price, '', 0, ",", "."));
                            var total_amount = price + deposit_price;
                            $('#total_amount').val(total_amount);
                            $('#textTotalAmount').text('Rp ' + accounting.formatMoney(total_amount, '', 0, ",", "."));
                        } else {
                            $('#amount').val(0);
                            $('#textAmount').text('Rp 0');
                            $('#deposit_price').val(0);
                            $('#textDeposit').text('Rp 0');
                            $('#total_amount').val(0);
                            $('#textTotalAmount').text('Rp 0');
                        }
                        calculateDate();
                    }
                });
            });

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

            document.addEventListener('DOMContentLoaded', function() {
                const ktp_photo_transaction = document.getElementById('ktp_photo_transaction');
                const ktp_display = document.querySelector('.ktp_display');

                ktp_photo_transaction.addEventListener('change', function(e) {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();

                        ktp_display.textContent = this.files[0].name;
                        ktp_display.style.color = '#28a745';

                        var previewContainer = this.closest('.file-input-wrapper').nextElementSibling;
                        if (!previewContainer || !previewContainer.classList.contains('image-preview-container')) {
                            previewContainer = document.createElement('div');
                            previewContainer.className = 'image-preview-container mt-2';
                            this.closest('.group-input').appendChild(previewContainer);
                        } else {
                            previewContainer.innerHTML = '';
                        }

                        reader.onload = function(e) {
                            const imgPreview = document.createElement('img');
                            imgPreview.src = e.target.result;
                            imgPreview.style.maxWidth = '200px';
                            imgPreview.style.maxHeight = '200px';
                            previewContainer.appendChild(imgPreview);
                        }

                        reader.readAsDataURL(this.files[0]);
                    }
                });

                const kk_photo_transaction = document.getElementById('kk_photo_transaction');
                const kk_display = document.querySelector('.kk_display');

                kk_photo_transaction.addEventListener('change', function(e) {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();

                        kk_display.textContent = this.files[0].name;
                        kk_display.style.color = '#28a745';

                        var previewContainer = this.closest('.file-input-wrapper').nextElementSibling;
                        if (!previewContainer || !previewContainer.classList.contains('image-preview-container')) {
                            previewContainer = document.createElement('div');
                            previewContainer.className = 'image-preview-container mt-2';
                            this.closest('.group-input').appendChild(previewContainer);
                        } else {
                            previewContainer.innerHTML = '';
                        }

                        reader.onload = function(e) {
                            const imgPreview = document.createElement('img');
                            imgPreview.src = e.target.result;
                            imgPreview.style.maxWidth = '200px';
                            imgPreview.style.maxHeight = '200px';
                            previewContainer.appendChild(imgPreview);
                        }

                        reader.readAsDataURL(this.files[0]);
                    }
                });
            });
        </script>
    @endpush
@endsection
