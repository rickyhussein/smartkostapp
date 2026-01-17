@extends('layouts.appowner')

@section('back')
    <a href="{{ url('/properties/owner') }}" class="back-btn"> <i class="icon-left"></i> </a>
@endsection

@section('container')
    <form class="tf-form" action="{{ url('/properties/owner/store') }}" enctype="multipart/form-data" method="POST">
        <div id="app-wrap" class="mt-4">
            <div class="bill-content">
                <div class="card-secton transfer-section mt-2">
                    <div class="tf-container ms-2 me-2">
                        @csrf
                        <div class="card" style="border-radius: 10px; border: 1px solid #acacac; font-size: 14px;">
                            <div class="card-body">
                                <h4 class="mb-4">Informasi</h4>

                                <div class="group-input">
                                    <label for="name">Nama</label>
                                    <input type="text" class="@error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="group-input">
                                    <label for="category" style="z-index: 100">Kategori</label>
                                    <select style="width: 100%" name="category" id="category" class="@error('category') is-invalid @enderror select2" data-live-search="true">
                                        <option value="">-- Pilih Kategori --</option>
                                        <option value="Kos Putra" {{ 'Kos Putra' == old('category') ? 'selected="selected"' : '' }}>Kos Putra</option>
                                        <option value="Kos Putri" {{ 'Kos Putri' == old('category') ? 'selected="selected"' : '' }}>Kos Putri</option>
                                        <option value="Kos Campur" {{ 'Kos Campur' == old('category') ? 'selected="selected"' : '' }}>Kos Campur</option>
                                        <option value="Kontrakan" {{ 'Kontrakan' == old('category') ? 'selected="selected"' : '' }}>Kontrakan</option>
                                    </select>
                                    @error('rt')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="group-input">
                                    <label for="description">Deskripsi</label>
                                    <textarea name="description" id="description" class="@error('description') is-invalid @enderror" cols="30" rows="5" style="resize: vertical;" onblur="this.style.boxShadow='none'" placeholder="Ceritakan hal yang menarik tentang Kos Anda">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="group-input">
                                    <label for="admin_name">Nama Pengelola</label>
                                    <input type="text" class="@error('admin_name') is-invalid @enderror" id="admin_name" name="admin_name" value="{{ old('admin_name', auth()->user()->name) }}">
                                    @error('admin_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="group-input">
                                    <label for="admin_number">Nomor HP Pengelola</label>
                                    <input type="number" class="@error('admin_number') is-invalid @enderror" id="admin_number" name="admin_number" value="{{ old('admin_number', auth()->user()->phone_number) }}">
                                    @error('admin_number')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="card" style="border-radius: 10px; border: 1px solid #acacac; font-size: 14px;">
                            <div class="card-body">
                                <h4 class="mb-4">Fasilitas</h4>
                                <div class="row">
                                    @foreach ($facilities as $facility)
                                        <div class="col-6">
                                            <div class="form-check">
                                                <input type="checkbox" name="facility_id[]" {{ (is_array(old('facility_id')) && in_array($facility->id, old('facility_id'))) ? 'checked' : '' }} class="form-check-input facility_id" id="facility_id_{{ $facility->id }}" value="{{ $facility->id }}">
                                                <label class="form-check-label" for="facility_id_{{ $facility->id }}">
                                                    {{ $facility->name ?? '-' }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="card" style="border-radius: 10px; border: 1px solid #acacac; font-size: 14px;">
                            <div class="card-body">
                                <h4 class="mb-4">Peraturan</h4>
                                @foreach ($regulations as $regulation)
                                    <div class="form-check">
                                        <input type="checkbox" name="regulation_id[]" {{ (is_array(old('regulation_id')) && in_array($regulation->id, old('regulation_id'))) ? 'checked' : '' }} class="form-check-input regulation_id" id="regulation_id_{{ $regulation->id }}" value="{{ $regulation->id }}">
                                        <label class="form-check-label" for="regulation_id_{{ $regulation->id }}">
                                            {{ $regulation->name ?? '-' }}
                                        </label>
                                    </div>
                                @endforeach

                                <h4 class="mt-4 mb-2">Punya Peraturan Sendiri? Silahkan Upload Gambarnya</h4>
                                <div class="group-input">
                                    <div class="file-input-wrapper">
                                        <input class="form-control regulation_file_path @error('regulation_file_path') is-invalid @enderror" type="file" id="regulation_file_path" name="regulation_file_path" accept="image/*">
                                        <div class="file-name-display">
                                            <span class="room_display">Belum ada file dipilih</span>
                                        </div>
                                    </div>
                                    @error('regulation_file_path')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="card" style="border-radius: 10px; border: 1px solid #acacac; font-size: 14px;">
                            <div class="card-body">
                                <h4 class="mb-4">Alamat</h4>

                                <div class="group-input">
                                    <label for="address" style="z-index: 1000">Alamat Lengkap</label>
                                    <textarea name="address" id="address" class="@error('address') is-invalid @enderror" cols="30" rows="5" style="resize: vertical;" onblur="this.style.boxShadow='none'" placeholder="Cari alamat">{{ old('address') }}</textarea>
                                    <div id="address-suggestions" class="suggestions-container"></div>
                                    @error('address')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>


                                <button type="button" id="current-location-btn" class="tf-btn secondary">
                                    <i class="fa fa-location-arrow"></i> Gunakan Lokasi Saat Ini
                                </button>

                                <div class="tf-spacing-16"></div>
                                <div class="tf-spacing-16"></div>

                                <div class="group-input">
                                    <label for="province_id" style="z-index: 1000;">Provinsi</label>
                                    <select style="width: 100%" name="province_id" id="province_id" class="select2 @error('province_id') is-invalid @enderror">
                                        <option value="">-- Pilih Provinsi --</option>
                                        @foreach ($provinces as $province)
                                            <option value="{{ $province->id }}" {{ $province->id == old('province_id') ? 'selected="selected"' : '' }}>{{ $province->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('province_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="tf-spacing-16"></div>

                                <div class="group-input">
                                    <label for="city_id" style="z-index: 1000;">Kota / Kabupaten</label>
                                    <select style="width: 100%" name="city_id" id="city_id" class="select2 @error('city_id') is-invalid @enderror">
                                        <option value="">-- Pilih Kota / Kabupaten --</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}" {{ $city->id == old('city_id') ? 'selected="selected"' : '' }}>{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('city_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="tf-spacing-16"></div>

                                <div class="group-input">
                                    <label for="district_id" style="z-index: 1000;">Kecamatan</label>
                                    <select style="width: 100%" name="district_id" id="district_id" class="select2 @error('district_id') is-invalid @enderror">
                                        <option value="">-- Pilih Kecamatan --</option>
                                        @foreach ($districts as $district)
                                            <option value="{{ $district->id }}" {{ $district->id == old('district_id') ? 'selected="selected"' : '' }}>{{ $district->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('district_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="tf-spacing-16"></div>

                                <div class="group-input">
                                    <label for="village_id" style="z-index: 1000;">Kelurahan</label>
                                    <select style="width: 100%" name="village_id" id="village_id" class="select2 @error('village_id') is-invalid @enderror">
                                        <option value="">-- Pilih Kelurahan --</option>
                                        @foreach ($villages as $village)
                                            <option value="{{ $village->id }}" {{ $village->id == old('village_id') ? 'selected="selected"' : '' }}>{{ $village->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('village_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="row" style="display: none;">
                                    <div class="col-6">
                                        <div class="group-input">
                                            <label for="latitude">Latitude</label>
                                            <input type="text" id="latitude" name="latitude" class="@error('latitude') is-invalid @enderror" value="{{ old('latitude') }}" readonly>
                                            @error('latitude')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="group-input">
                                            <label for="longitude">Longitude</label>
                                            <input type="text" id="longitude" name="longitude" class="@error('longitude') is-invalid @enderror" value="{{ old('longitude') }}" readonly>
                                            @error('longitude')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="group-input">
                                    <div id="map" style="height: 300px; border-radius: 8px;"></div>
                                    <small class="text-muted">Klik pada peta atau geser marker untuk mengubah lokasi</small>
                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="card" style="border-radius: 10px; border: 1px solid #acacac; font-size: 14px;">
                            <div class="card-body">
                                <h4 class="mb-4">Foto & Video</h4>
                                <div id="propertyContainer">
                                    <div class="propertyItem">
                                        <label for="property_file_path">Foto 1</label>
                                        <div class="group-input">
                                            <div class="row">
                                                <div class="col-10">
                                                    <div class="file-input-wrapper">
                                                        <input class="form-control" type="file" name="property_file_path[]" accept="image/*" required>
                                                        <div class="file-name-display">
                                                            <span class="current-file">Belum ada file dipilih</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <button class="tf-btn danger large delete" style="font-size: 12px">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="tf-btn success large addProperty">+ Tambah Foto</button>
                                <br>
                                <label for="video_file_path">Video</label>
                                <div class="group-input">
                                    <div class="file-input-wrapper">
                                        <input class="form-control @error('video_file_path') is-invalid @enderror" type="file" id="video_file_path" name="video_file_path" accept="video/*">
                                        <div class="file-name-display">
                                            <span class="video_file_name">Belum ada file dipilih</span>
                                        </div>
                                        <div class="error-message" id="errorMessage"></div>
                                        @error('video_file_path')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="video-preview">
                                    <h2>Pratinjau Video</h2>
                                    <video id="videoPlayer" autoplay controls>
                                        Browser Anda tidak mendukung pemutaran video.
                                    </video>
                                    <p id="noVideoText" style="margin-top: 15px;">Silakan pilih file video untuk melihat pratinjau</p>
                                </div>
                                <div id="screenshotInputContainer" class="hidden screenshot-input">
                                    <label for="screenshot_video">Screenshot Video (Otomatis)</label>
                                    <div class="group-input">
                                        <div class="file-input-wrapper">
                                            <input class="form-control" type="file" id="screenshot_video" name="screenshot_video" accept="image/*">
                                            <div class="file-name-display">
                                                <span class="screenshot_file_name">Screenshot akan dibuat otomatis</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="screenshot-preview">
                                        <img id="screenshotPreview" alt="Screenshot video">
                                    </div>
                                </div>
                                <canvas id="screenshotCanvas" class="hidden"></canvas>
                            </div>
                        </div>
                        <br>

                        @php
                            $old = session()->getOldInput();
                        @endphp

                        <div class="card" style="border-radius: 10px; border: 1px solid #acacac; font-size: 14px;">
                            <div class="card-body">
                                <h4 class="mb-4">Detail Kamar</h4>
                                <div id="roomContainer">
                                    @if(isset($old['room_name']))
                                        @foreach ($old['room_name'] as $key => $roomName)
                                            <div class="card text-dark bg-light roomItem" style="border-radius: 15px; margin-bottom: 15px;">
                                                <div class="card-body">
                                                    <label for="room_name">Nama / Nomor Kamar</label>
                                                    <div class="group-input">
                                                        <input type="text" name="room_name[]" class="room_name" value="{{ old('room_name')[$key] }}" required>
                                                    </div>
                                                    <label for="room_type">Tipe Kamar</label>
                                                    <div class="group-input">
                                                        <input type="text" name="room_type[]" class="room_type" value="{{ old('room_type')[$key] }}">
                                                    </div>
                                                    <label for="floor">Lantai</label>
                                                    <div class="group-input">
                                                        <input type="text" name="floor[]" class="floor" value="{{ old('floor')[$key] }}">
                                                    </div>
                                                    <div class="row mb-6">
                                                        <div class="col-6">
                                                            <label for="room_height">Panjang Ruangan</label>
                                                            <div class="input-group">
                                                                <input type="number" class="form-control" name="room_height[]" style="border: 1px solid #acacac;" value="{{ old('room_height')[$key] }}">
                                                                <span class="input-group-text" style="border: 1px solid #acacac; width: 50px;">M</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <label for="room_width">Lebar Ruangan</label>
                                                            <div class="input-group">
                                                                <input type="number" class="form-control" name="room_width[]" style="border: 1px solid #acacac;" value="{{ old('room_width')[$key] }}">
                                                                <span class="input-group-text" style="border: 1px solid #acacac; width: 50px;">M</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <label for="one_month_price">Harga Per Bulan</label>
                                                    <div class="input-group mb-6">
                                                        <span class="input-group-text" style="border: 1px solid #acacac; background-color:#f8f8f8">Rp</span>
                                                        <input type="text" class="form-control money" name="one_month_price[]" style="border: 1px solid #acacac;" required value="{{ old('one_month_price')[$key] }}">
                                                        <span class="input-group-text" style="border: 1px solid #acacac; width: 100px;background-color:#f8f8f8;">/ Bulan</span>
                                                    </div>
                                                    <label for="three_month_price">Harga Per 3 Bulan</label>
                                                    <div class="input-group mb-6">
                                                        <span class="input-group-text" style="border: 1px solid #acacac; background-color:#f8f8f8">Rp</span>
                                                        <input type="text" class="form-control money" name="three_month_price[]" style="border: 1px solid #acacac;" value="{{ old('three_month_price')[$key] }}">
                                                        <span class="input-group-text" style="border: 1px solid #acacac; width: 100px;background-color:#f8f8f8;">/ Bulan</span>
                                                    </div>
                                                    <label for="six_month_price">Harga Per 6 Bulan</label>
                                                    <div class="input-group mb-6">
                                                        <span class="input-group-text" style="border: 1px solid #acacac; background-color:#f8f8f8">Rp</span>
                                                        <input type="text" class="form-control money" name="six_month_price[]" style="border: 1px solid #acacac;" value="{{ old('six_month_price')[$key] }}">
                                                        <span class="input-group-text" style="border: 1px solid #acacac; width: 100px;background-color:#f8f8f8;">/ Bulan</span>
                                                    </div>
                                                    <label for="twelve_month_price">Harga Per 12 Bulan</label>
                                                    <div class="input-group mb-6">
                                                        <span class="input-group-text" style="border: 1px solid #acacac; background-color:#f8f8f8">Rp</span>
                                                        <input type="text" class="form-control money" name="twelve_month_price[]" style="border: 1px solid #acacac;" value="{{ old('twelve_month_price')[$key] }}">
                                                        <span class="input-group-text" style="border: 1px solid #acacac; width: 100px;background-color:#f8f8f8;">/ Bulan</span>
                                                    </div>
                                                    <label for="deposit_price">Biaya Deposit</label>
                                                    <div class="input-group mb-6">
                                                        <span class="input-group-text" style="border: 1px solid #acacac; background-color:#f8f8f8">Rp</span>
                                                        <input type="text" class="form-control money" name="deposit_price[]" style="border: 1px solid #acacac;" value="{{ old('deposit_price')[$key] }}">
                                                    </div>
                                                    <label for="room_file_path">Foto Kamar</label>
                                                    <div class="group-input">
                                                        <div class="file-input-wrapper">
                                                            <input class="form-control room_file_path" required type="file" name="room_file_path[]" accept="image/*">
                                                            <div class="file-name-display">
                                                                <span class="room_display">Belum ada file dipilih</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="box-card">
                                                        <div class="tf-card-list medium">
                                                            <div class="info">
                                                                <h4 class="fw_6">Kamar Sudah Terisi</h4>
                                                            </div>
                                                            <input type="checkbox" name="select_available[]" {{ old('is_available')[$key] == 1 ? 'checked' : ''}} class="tf-checkbox circle-check select_available">
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="is_available[]" class="is_available" value="{{ old('is_available')[$key] }}">
                                                    <br>
                                                    <button class="tf-btn danger large deleteRoom" style="font-size: 12px"><i class="fa fa-trash me-1"></i>Hapus</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="card text-dark bg-light roomItem" style="border-radius: 15px; margin-bottom: 15px;">
                                            <div class="card-body">
                                                <label for="room_name">Nama / Nomor Kamar</label>
                                                <div class="group-input">
                                                    <input type="text" name="room_name[]" class="room_name" value="1" required>
                                                </div>
                                                <label for="room_type">Tipe Kamar</label>
                                                <div class="group-input">
                                                    <input type="text" name="room_type[]" class="room_type">
                                                </div>
                                                <label for="floor">Lantai</label>
                                                <div class="group-input">
                                                    <input type="text" name="floor[]" class="floor">
                                                </div>
                                                <div class="row mb-6">
                                                    <div class="col-6">
                                                        <label for="room_height">Panjang Ruangan</label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" name="room_height[]" style="border: 1px solid #acacac;">
                                                            <span class="input-group-text" style="border: 1px solid #acacac; width: 50px;">M</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="room_width">Lebar Ruangan</label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" name="room_width[]" style="border: 1px solid #acacac;">
                                                            <span class="input-group-text" style="border: 1px solid #acacac; width: 50px;">M</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <label for="one_month_price">Harga Per Bulan</label>
                                                <div class="input-group mb-6">
                                                    <span class="input-group-text" style="border: 1px solid #acacac; background-color:#f8f8f8">Rp</span>
                                                    <input type="text" class="form-control money" name="one_month_price[]" style="border: 1px solid #acacac;" required>
                                                    <span class="input-group-text" style="border: 1px solid #acacac; width: 100px;background-color:#f8f8f8;">/ Bulan</span>
                                                </div>
                                                <label for="three_month_price">Harga Per 3 Bulan</label>
                                                <div class="input-group mb-6">
                                                    <span class="input-group-text" style="border: 1px solid #acacac; background-color:#f8f8f8">Rp</span>
                                                    <input type="text" class="form-control money" name="three_month_price[]" style="border: 1px solid #acacac;">
                                                    <span class="input-group-text" style="border: 1px solid #acacac; width: 100px;background-color:#f8f8f8;">/ Bulan</span>
                                                </div>
                                                <label for="six_month_price">Harga Per 6 Bulan</label>
                                                <div class="input-group mb-6">
                                                    <span class="input-group-text" style="border: 1px solid #acacac; background-color:#f8f8f8">Rp</span>
                                                    <input type="text" class="form-control money" name="six_month_price[]" style="border: 1px solid #acacac;">
                                                    <span class="input-group-text" style="border: 1px solid #acacac; width: 100px;background-color:#f8f8f8;">/ Bulan</span>
                                                </div>
                                                <label for="twelve_month_price">Harga Per 12 Bulan</label>
                                                <div class="input-group mb-6">
                                                    <span class="input-group-text" style="border: 1px solid #acacac; background-color:#f8f8f8">Rp</span>
                                                    <input type="text" class="form-control money" name="twelve_month_price[]" style="border: 1px solid #acacac;">
                                                    <span class="input-group-text" style="border: 1px solid #acacac; width: 100px;background-color:#f8f8f8;">/ Bulan</span>
                                                </div>
                                                <label for="deposit_price">Biaya Deposit</label>
                                                <div class="input-group mb-6">
                                                    <span class="input-group-text" style="border: 1px solid #acacac; background-color:#f8f8f8">Rp</span>
                                                    <input type="text" class="form-control money" name="deposit_price[]" style="border: 1px solid #acacac;">
                                                </div>
                                                <label for="room_file_path">Foto Kamar</label>
                                                <div class="group-input">
                                                    <div class="file-input-wrapper">
                                                        <input class="form-control room_file_path" required type="file" name="room_file_path[]" accept="image/*">
                                                        <div class="file-name-display">
                                                            <span class="room_display">Belum ada file dipilih</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="box-card">
                                                    <div class="tf-card-list medium">
                                                        <div class="info">
                                                            <h4 class="fw_6">Kamar Sudah Terisi</h4>
                                                        </div>
                                                        <input type="checkbox" name="select_available[]" class="tf-checkbox circle-check select_available">
                                                    </div>
                                                </div>
                                                <input type="hidden" name="is_available[]" class="is_available">
                                                <br>
                                                <button class="tf-btn danger large deleteRoom" style="font-size: 12px"><i class="fa fa-trash me-1"></i>Hapus</button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <br>
                                <button class="tf-btn success large addRoom">+ Tambah Kamar</button>
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

                    </div>
                </div>
            </div>
        </div>

        <div class="bottom-navigation-bar st2 bottom-btn-fixed" style="bottom:65px">
            <div class="tf-container">
                <button type="submit" class="tf-btn accent large">Simpan</button>
            </div>
        </div>
    </form>

    @push('style')
        <style>
            .suggestions-container {
                position: absolute;
                z-index: 10000;
                width: calc(100% - 30px);
                max-height: 200px;
                overflow-y: auto;
                background: white;
                border: 1px solid #ddd;
                border-radius: 4px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.2);
                display: none;
            }
            .suggestion-item {
                padding: 8px 12px;
                cursor: pointer;
                border-bottom: 1px solid #eee;
                z-index: 10000;
            }
            .suggestion-item:hover {
                background-color: #f5f5f5;
            }
            .suggestion-item:last-child {
                border-bottom: none;
            }
            .input-group {
                display: flex;
            }
            #address {
                flex: 1;
            }
            #current-location-btn {
                height: 44px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            #map {
                margin-top: 10px;
            }
            .pac-container {
                z-index: 1051 !important;
            }

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
                border-radius: 8px;
                pointer-events: none;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
                height: calc(2.25rem + 2px);
                line-height: 1.5;
            }

            .file-name-display .current-file {
                color: #495057;
                font-size: 0.875rem;
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

            .image-preview img {
                margin-top: 10px;
                padding: 5px;
                border: 1px dashed #ccc;
                border-radius: 4px;
                display: inline-block;
            }

            .image-preview-container {
                margin-top: 10px;
                padding: 5px;
                border: 1px dashed #ccc;
                border-radius: 4px;
                display: inline-block;
            }

            .video-preview {
                margin-top: 30px;
                text-align: center;
            }

            .video-preview h2 {
                margin-bottom: 15px;
                color: #fdbb2d;
            }

            #videoPlayer {
                width: 100%;
                max-height: 500px;
                border-radius: 10px;
                background-color: #000;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
                display: none;
            }

            .hidden {
                display: none;
            }

            .screenshot-input {
                margin-top: 20px;
                padding: 15px;
                background-color: #f8f9fa;
                border-radius: 8px;
                border: 1px dashed #6c757d;
            }

            #noVideoText {
                margin-top: 15px;
                color: #6c757d;
                font-style: italic;
            }

            .error-message {
                color: #dc3545;
                margin-top: 8px;
                display: none;
            }

            @media (max-width: 768px) {
                #videoPlayer {
                    max-height: 300px;
                }
            }
        </style>
    @endpush

    @push('script')
        <script>
            $('.money').mask('000,000,000,000,000', {
                reverse: true
            });

            $('.select2').select2();

            let map, marker;
            let addressInput = document.getElementById('address');
            let suggestionsContainer = document.getElementById('address-suggestions');
            let currentLocationBtn = document.getElementById('current-location-btn');
            let debounceTimer;

            function initMap(lat = -6.2088, lng = 106.8456) {
                if (map) {
                    map.setView([lat, lng], 15);
                    if (marker) {
                        marker.setLatLng([lat, lng]);
                    } else {
                        marker = L.marker([lat, lng], {draggable: true}).addTo(map);
                        marker.bindPopup("Lokasi terpilih").openPopup();
                    }
                    return;
                }

                map = L.map('map').setView([lat, lng], 15);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                marker = L.marker([lat, lng], {
                    draggable: true
                }).addTo(map)
                .bindPopup("Lokasi terpilih")
                .openPopup();

                marker.on('dragend', function(e) {
                    const position = marker.getLatLng();
                    updateCoordinateInputs(position.lat, position.lng);
                    getAddressFromCoordinates(position.lat, position.lng);
                });

                map.on('click', function(e) {
                    const latlng = e.latlng;
                    updateCoordinateInputs(latlng.lat, latlng.lng);

                    if (marker) {
                        map.removeLayer(marker);
                    }

                    marker = L.marker(latlng, {
                        draggable: true
                    }).addTo(map)
                    .bindPopup("Lokasi terpilih")
                    .openPopup();

                    getAddressFromCoordinates(latlng.lat, latlng.lng);

                    marker.on('dragend', function(e) {
                        const position = marker.getLatLng();
                        updateCoordinateInputs(position.lat, position.lng);
                        getAddressFromCoordinates(position.lat, position.lng);
                    });
                });
            }

            function updateCoordinateInputs(lat, lng) {
                $('#latitude').val(lat);
                $('#longitude').val(lng);
            }

            function getCurrentLocation() {
                if (navigator.geolocation) {
                    currentLocationBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
                    currentLocationBtn.disabled = true;

                    navigator.geolocation.getCurrentPosition(
                        function(position) {
                            const lat = position.coords.latitude;
                            const lng = position.coords.longitude;

                            updateCoordinateInputs(lat, lng);
                            initMap(lat, lng);
                            getAddressFromCoordinates(lat, lng);

                            currentLocationBtn.innerHTML = '<i class="fa fa-location-arrow"></i> Gunakan Lokasi Saat Ini';
                            currentLocationBtn.disabled = false;
                        },
                        function(error) {
                            console.error("Error getting location: ", error);
                            alert('Tidak dapat mendapatkan lokasi saat ini. Pastikan Anda mengizinkan akses lokasi.');
                            currentLocationBtn.innerHTML = '<i class="fa fa-location-arrow"></i> Gunakan Lokasi Saat Ini';
                            currentLocationBtn.disabled = false;
                            initMap();
                        },
                        {
                            enableHighAccuracy: true,
                            timeout: 10000,
                            maximumAge: 0
                        }
                    );
                } else {
                    alert('Browser Anda tidak mendukung geolokasi.');
                    initMap();
                }
            }

            function getAddressFromCoordinates(lat, lng) {
                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.display_name) {
                            addressInput.value = data.display_name;
                            if (marker) {
                                marker.setPopupContent(data.display_name).openPopup();
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error getting address:', error);
                    });
            }

            function searchAddress(query) {
                if (query.length < 3) {
                    suggestionsContainer.style.display = 'none';
                    return;
                }

                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&addressdetails=1&limit=5`)
                        .then(response => response.json())
                        .then(data => {
                            suggestionsContainer.innerHTML = '';

                            if (data.length > 0) {
                                data.forEach(item => {
                                    const suggestionItem = document.createElement('div');
                                    suggestionItem.className = 'suggestion-item';
                                    suggestionItem.textContent = item.display_name;

                                    suggestionItem.addEventListener('click', () => {
                                        addressInput.value = item.display_name;
                                        updateCoordinateInputs(item.lat, item.lon);
                                        initMap(item.lat, item.lon);
                                        suggestionsContainer.style.display = 'none';
                                        marker.setPopupContent(item.display_name).openPopup();
                                    });

                                    suggestionsContainer.appendChild(suggestionItem);
                                });

                                suggestionsContainer.style.display = 'block';
                            } else {
                                suggestionsContainer.style.display = 'none';
                            }
                        })
                        .catch(error => {
                            console.error('Error searching address:', error);
                            suggestionsContainer.style.display = 'none';
                        });
                }, 300);
            }

            addressInput.addEventListener('input', function() {
                searchAddress(this.value);
            });

            document.addEventListener('click', function(e) {
                if (e.target !== addressInput) {
                    suggestionsContainer.style.display = 'none';
                }
            });

            currentLocationBtn.addEventListener('click', getCurrentLocation);

            $(document).ready(function() {
                initMap();

                if ($('#latitude').val() && $('#longitude').val()) {
                    initMap(
                        parseFloat($('#latitude').val()),
                        parseFloat($('#longitude').val())
                    );
                }
            });

            $('.addProperty').click(function(e) {
                e.preventDefault();
                let fotoCount = $('#propertyContainer .propertyItem').length + 1;
                let newFoto = `
                    <div class="propertyItem">
                        <label for="property_file_path">Foto ${fotoCount}</label>
                        <div class="group-input">
                            <div class="row">
                                <div class="col-10">
                                    <div class="file-input-wrapper">
                                        <input class="form-control" type="file" name="property_file_path[]" accept="image/*" required>
                                        <div class="file-name-display">
                                            <span class="current-file">Belum ada file dipilih</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <button class="tf-btn danger large delete" style="font-size: 12px">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                $('#propertyContainer').append(newFoto);
            });

            $('#propertyContainer').on('click', '.delete', function(e) {
                e.preventDefault();
                let fotoCount = $('#propertyContainer .propertyItem').length;

                if (fotoCount <= 1) {
                    alert('Minimal harus ada satu foto');
                } else {
                    if (confirm('Apakah Anda yakin ingin menghapus foto ini?')) {
                        const propertyItem = $(this).closest('.propertyItem');
                        propertyItem.remove();
                        $('#propertyContainer .propertyItem').each(function(index) {
                            $(this).find('label').text('Foto ' + (index + 1));
                        });
                    }
                }
            });

            $('.addRoom').click(function(e) {
                e.preventDefault();
                let roomCount = $('#roomContainer .roomItem').length + 1;
                let newRoom = `
                    <br>
                    <div class="card text-dark bg-light roomItem" style="border-radius: 15px; margin-bottom: 15px;">
                        <div class="card-body">
                            <label for="room_name">Nama / Nomor Kamar</label>
                            <div class="group-input">
                                <input type="text" name="room_name[]" class="room_name" value="${roomCount}" required>
                            </div>
                            <label for="room_type">Tipe Kamar</label>
                            <div class="group-input">
                                <input type="text" name="room_type[]" class="room_type">
                            </div>
                            <label for="floor">Lantai</label>
                            <div class="group-input">
                                <input type="text" name="floor[]" class="floor">
                            </div>
                            <div class="row mb-6">
                                <div class="col-6">
                                    <label for="room_height">Panjang Ruangan</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="room_height[]" style="border: 1px solid #acacac;">
                                        <span class="input-group-text" style="border: 1px solid #acacac; width: 50px;">M</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="room_width">Lebar Ruangan</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="room_width[]" style="border: 1px solid #acacac;">
                                        <span class="input-group-text" style="border: 1px solid #acacac; width: 50px;">M</span>
                                    </div>
                                </div>
                            </div>
                            <label for="one_month_price">Harga Per Bulan</label>
                            <div class="input-group mb-6">
                                <span class="input-group-text" style="border: 1px solid #acacac; background-color:#f8f8f8">Rp</span>
                                <input type="text" class="form-control money" name="one_month_price[]" style="border: 1px solid #acacac;" required>
                                <span class="input-group-text" style="border: 1px solid #acacac; width: 100px;background-color:#f8f8f8;">/ Bulan</span>
                            </div>
                            <label for="three_month_price">Harga Per 3 Bulan</label>
                            <div class="input-group mb-6">
                                <span class="input-group-text" style="border: 1px solid #acacac; background-color:#f8f8f8">Rp</span>
                                <input type="text" class="form-control money" name="three_month_price[]" style="border: 1px solid #acacac;">
                                <span class="input-group-text" style="border: 1px solid #acacac; width: 100px;background-color:#f8f8f8;">/ Bulan</span>
                            </div>
                            <label for="six_month_price">Harga Per 6 Bulan</label>
                            <div class="input-group mb-6">
                                <span class="input-group-text" style="border: 1px solid #acacac; background-color:#f8f8f8">Rp</span>
                                <input type="text" class="form-control money" name="six_month_price[]" style="border: 1px solid #acacac;">
                                <span class="input-group-text" style="border: 1px solid #acacac; width: 100px;background-color:#f8f8f8;">/ Bulan</span>
                            </div>
                            <label for="twelve_month_price">Harga Per 12 Bulan</label>
                            <div class="input-group mb-6">
                                <span class="input-group-text" style="border: 1px solid #acacac; background-color:#f8f8f8">Rp</span>
                                <input type="text" class="form-control money" name="twelve_month_price[]" style="border: 1px solid #acacac;">
                                <span class="input-group-text" style="border: 1px solid #acacac; width: 100px;background-color:#f8f8f8;">/ Bulan</span>
                            </div>
                            <label for="deposit_price">Biaya Deposit</label>
                            <div class="input-group mb-6">
                                <span class="input-group-text" style="border: 1px solid #acacac; background-color:#f8f8f8">Rp</span>
                                <input type="text" class="form-control money" name="deposit_price[]" style="border: 1px solid #acacac;">
                            </div>
                            <label for="room_file_path">Foto Kamar</label>
                            <div class="group-input">
                                <div class="file-input-wrapper">
                                    <input class="form-control room_file_path" required type="file" name="room_file_path[]" accept="image/*">
                                    <div class="file-name-display">
                                        <span class="room_display">Belum ada file dipilih</span>
                                    </div>
                                </div>
                            </div>
                            <div class="box-card">
                                <div class="tf-card-list medium">
                                    <div class="info">
                                        <h4 class="fw_6">Kamar Sudah Terisi</h4>
                                    </div>
                                    <input type="checkbox" name="select_available[]" class="tf-checkbox circle-check select_available">
                                </div>
                            </div>
                            <input type="hidden" name="is_available[]" class="is_available">
                            <br>
                            <button class="tf-btn danger large deleteRoom" style="font-size: 12px"><i class="fa fa-trash me-1"></i>Hapus</button>
                        </div>
                    </div>
                `;

                $('#roomContainer').append(newRoom);

                if (typeof $.fn.tfCheckbox !== 'undefined') {
                    $('.tf-checkbox').tfCheckbox();
                }
            });

            $('#roomContainer').on('click', '.deleteRoom', function(e) {
                e.preventDefault();
                let roomCount = $('#roomContainer .roomItem').length;

                if (roomCount <= 1) {
                    alert('Minimal harus ada satu kamar');
                } else {
                    if (confirm('Apakah Anda yakin ingin menghapus kamar ini?')) {
                        const roomItem = $(this).closest('.roomItem');
                        roomItem.remove();
                    }
                }
            });

            $('body').on('change', '.select_available', function (event) {
                $(this).closest('.roomItem').find('.is_available').val(this.checked ? 1 : null);
            });

            function readURL(input, previewContainer) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        let imgPreviewContainer = previewContainer.querySelector('.image-preview');

                        if (!imgPreviewContainer) {
                            imgPreviewContainer = document.createElement('div');
                            imgPreviewContainer.className = 'image-preview mt-2';
                            previewContainer.appendChild(imgPreviewContainer);
                        }

                        let imgPreview = imgPreviewContainer.querySelector('img');

                        if (!imgPreview) {
                            imgPreview = document.createElement('img');
                            imgPreview.style.maxWidth = '200px';
                            imgPreview.style.maxHeight = '200px';
                            imgPreviewContainer.appendChild(imgPreview);
                        }

                        imgPreview.src = e.target.result;

                        const fileNameDisplay = input.closest('.file-input-wrapper').querySelector('.current-file');
                        fileNameDisplay.textContent = input.files[0].name;
                        fileNameDisplay.style.color = '#28a745';
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            document.getElementById('propertyContainer').addEventListener('change', function(e) {
                if (e.target && e.target.matches('input[type="file"]')) {
                    const fileInput = e.target;
                    const groupInput = fileInput.closest('.group-input');
                    readURL(fileInput, groupInput);
                }
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('body').on('change', '#province_id', function(event) {
                let province_id = $(this).val();
                $.ajax({
                    type:'GET',
                    url:"{{ url('/get-city') }}",
                    data:{province_id:province_id},
                    success:function(data){
                        $('#city_id').empty();
                        $('#city_id').append('<option value="">-- Pilih Kota / Kabupaten --</option>');
                        $.each(data, function(key, city) {
                            $('#city_id').append('<option value="' + city.id + '">' + city.name + '</option>');
                        });

                        $('#district_id').empty();
                        $('#district_id').append('<option value="">-- Pilih Kecamatan --</option>');

                        $('#village_id').empty();
                        $('#village_id').append('<option value="">-- Pilih Kelurahan --</option>');
                    }
                });
            });

            $('body').on('change', '#city_id', function(event) {
                let city_id = $(this).val();
                $.ajax({
                    type:'GET',
                    url:"{{ url('/get-district') }}",
                    data:{city_id:city_id},
                    success:function(data){
                        $('#district_id').empty();
                        $('#district_id').append('<option value="">-- Pilih Kecamatan --</option>');
                        $.each(data, function(key, district) {
                            $('#district_id').append('<option value="' + district.id + '">' + district.name + '</option>');
                        });

                        $('#village_id').empty();
                        $('#village_id').append('<option value="">-- Pilih Kelurahan --</option>');
                    }
                });
            });

            $('body').on('change', '#district_id', function(event) {
                let district_id = $(this).val();
                $.ajax({
                    type:'GET',
                    url:"{{ url('/get-village') }}",
                    data:{district_id:district_id},
                    success:function(data){
                        $('#village_id').empty();
                        $('#village_id').append('<option value="">-- Pilih Kelurahan --</option>');
                        $.each(data, function(key, village) {
                            $('#village_id').append('<option value="' + village.id + '">' + village.name + '</option>');
                        });
                    }
                });
            });

            document.addEventListener('change', function(e) {
                if ((e.target && e.target.name === 'room_file_path[]') || (e.target && e.target.name === 'regulation_file_path')) {
                    const fileInput = e.target;
                    const fileWrapper = fileInput.closest('.file-input-wrapper');
                    const roomDisplay = fileWrapper.querySelector('.room_display');

                    if (fileInput.files && fileInput.files[0]) {
                        const reader = new FileReader();

                        roomDisplay.textContent = fileInput.files[0].name;
                        roomDisplay.style.color = '#28a745';

                        let previewContainer = fileWrapper.nextElementSibling;
                        if (previewContainer && previewContainer.classList.contains('image-preview-container')) {
                            previewContainer.remove();
                        }

                        previewContainer = document.createElement('div');
                        previewContainer.className = 'image-preview-container mt-2';
                        fileWrapper.parentNode.appendChild(previewContainer);

                        reader.onload = function(e) {
                            const imgPreview = document.createElement('img');
                            imgPreview.src = e.target.result;
                            imgPreview.style.maxWidth = '200px';
                            imgPreview.style.maxHeight = '200px';
                            imgPreview.style.borderRadius = '5px';
                            previewContainer.appendChild(imgPreview);
                        }

                        reader.readAsDataURL(fileInput.files[0]);
                    }
                }
            });

            document.addEventListener('DOMContentLoaded', function() {
                const videoInput = document.getElementById('video_file_path');
                const videoNameDisplay = document.querySelector('.video_file_name');
                const videoPlayer = document.getElementById('videoPlayer');
                const noVideoText = document.getElementById('noVideoText');
                const errorMessage = document.getElementById('errorMessage');
                const screenshotInputContainer = document.getElementById('screenshotInputContainer');
                const screenshotInput = document.getElementById('screenshot_video');
                const screenshotFileName = document.querySelector('.screenshot_file_name');
                const screenshotPreview = document.getElementById('screenshotPreview');
                const screenshotCanvas = document.getElementById('screenshotCanvas');
                const ctx = screenshotCanvas.getContext('2d');

                videoInput.addEventListener('change', function() {
                    const file = this.files[0];

                    if (file) {
                        if (!file.type.startsWith('video/')) {
                            errorMessage.textContent = 'Error: File yang dipilih bukan video. Silakan pilih file video.';
                            errorMessage.style.display = 'block';
                            videoPlayer.style.display = 'none';
                            noVideoText.style.display = 'block';
                            videoNameDisplay.textContent = 'Belum ada file dipilih';
                            screenshotInputContainer.classList.add('hidden');
                            return;
                        }

                        errorMessage.style.display = 'none';
                        videoNameDisplay.textContent = file.name;

                        const videoURL = URL.createObjectURL(file);
                        videoPlayer.src = videoURL;
                        videoPlayer.style.display = 'block';
                        noVideoText.style.display = 'none';

                        screenshotInputContainer.classList.add('hidden');

                        videoPlayer.addEventListener('loadeddata', function() {
                            if (videoPlayer.readyState >= 2) {
                                takeScreenshot();
                            }
                        });

                        videoPlayer.addEventListener('error', function() {
                            errorMessage.textContent = 'Error: Browser tidak dapat memutar file video ini. Silakan coba file video lain.';
                            errorMessage.style.display = 'block';
                            videoPlayer.style.display = 'none';
                            noVideoText.style.display = 'block';
                        });

                        videoPlayer.load();
                    } else {
                        videoNameDisplay.textContent = 'Belum ada file dipilih';
                        videoPlayer.style.display = 'none';
                        noVideoText.style.display = 'block';
                        screenshotInputContainer.classList.add('hidden');
                    }
                });

                function takeScreenshot() {
                    screenshotCanvas.width = videoPlayer.videoWidth;
                    screenshotCanvas.height = videoPlayer.videoHeight;

                    ctx.drawImage(videoPlayer, 0, 0, screenshotCanvas.width, screenshotCanvas.height);

                    const timestamp = new Date().getTime();
                    const randomString = Math.random().toString(36).substring(2, 15);
                    const uniqueFileName = `screenshot_${timestamp}_${randomString}.jpg`;

                    screenshotCanvas.toBlob(function(blob) {
                        const screenshotFile = new File([blob], uniqueFileName, {
                            type: 'image/jpeg',
                            lastModified: new Date().getTime()
                        });

                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(screenshotFile);

                        screenshotInput.files = dataTransfer.files;

                        screenshotFileName.textContent = screenshotFile.name;

                        const screenshotURL = URL.createObjectURL(blob);
                        screenshotPreview.src = screenshotURL;
                        screenshotPreview.style.display = 'block';

                        videoPlayer.pause();
                        videoPlayer.currentTime = 0;

                    }, 'image/jpeg', 0.8);
                }

                screenshotInput.addEventListener('change', function() {
                    if (this.files && this.files[0]) {
                        screenshotFileName.textContent = this.files[0].name;

                        const reader = new FileReader();
                        reader.onload = function(e) {
                            screenshotPreview.src = e.target.result;
                            screenshotPreview.style.display = 'block';
                        }
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            });
        </script>
    @endpush
@endsection
