@extends('layouts.appowner')
@section('back')
    <a href="{{ url('/dashboard/owner') }}" class="back-btn"> <i class="icon-left"></i> </a>
@endsection
@section('container')
    <form class="tf-form" action="{{ url('/profile/owner/update/'.$user->id) }}" enctype="multipart/form-data" method="POST">
        @method('PUT')
        @csrf
        <div id="app-wrap" class="mt-4">
            <div class="bill-content">
                <div class="repicient-content">
                <div class="tf-container">
                    <div class="box-user mt-5 text-center">
                        <div class="box-avatar">
                            @if($user->profile_photo == null)
                                <img src="{{ url('/assets/img/foto_default.jpg') }}" alt="image">
                            @else
                                <img src="{{ url('/storage/'.$user->profile_photo) }}" alt="image">
                            @endif
                        </div>
                        <h3 class="fw_8 mt-3">{{ strtoupper($user->name) }}</h3>
                    </div>
                </div>
                </div>
                <div class="tf-container ms-4 me-4">
                    <div class="card-secton transfer-section mt-2">
                        <div class="tf-spacing-20"></div>
                        <div class="group-input">
                            <label for="name">Nama</label>
                            <input type="text" class="@error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" />
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="tf-spacing-16"></div>

                        <div class="group-input">
                            <label for="email">Email</label>
                            <input type="email" class="@error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="tf-spacing-16"></div>

                        <div class="group-input">
                            <label for="phone_number">Nomor HP</label>
                            <input type="number" class="@error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}">
                            @error('phone_number')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="tf-spacing-16"></div>

                        <label for="profile_photo">Foto Profile</label>
                        <div class="group-input">
                            <div class="file-input-wrapper">
                                <input class="form-control @error('profile_photo') is-invalid @enderror" type="file" id="profile_photo" name="profile_photo" accept="image/*">
                                <div class="file-name-display">
                                    <span class="profile_display">{{ $user->profile_photo ? basename($user->profile_photo) : 'Belum ada file dipilih' }}</span>
                                </div>
                                @error('profile_photo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            @if ($user->profile_photo)
                                <div class="image-preview-container mt-2">
                                    <a href="{{ url('storage/'.$user->profile_photo) }}">
                                        <img src="{{ asset('storage/'.$user->profile_photo) }}" alt="Preview Foto" style="max-width: 200px; max-height: 200px;">
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="tf-spacing-16"></div>

                        <div class="group-input">
                            <label for="ktp_number">Nomor KTP</label>
                            <input type="number" class="@error('ktp_number') is-invalid @enderror" id="ktp_number" name="ktp_number" value="{{ old('ktp_number', $user->ktp_number) }}">
                            @error('ktp_number')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <label for="ktp_photo">Foto KTP</label>
                        <div class="group-input">
                            <div class="file-input-wrapper">
                                <input class="form-control @error('ktp_photo') is-invalid @enderror" type="file" id="ktp_photo" name="ktp_photo" accept="image/*">
                                <div class="file-name-display">
                                    <span class="ktp_display">{{ $user->ktp_photo ? basename($user->ktp_photo) : 'Belum ada file dipilih' }}</span>
                                </div>
                                @error('ktp_photo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            @if ($user->ktp_photo)
                                <div class="image-preview-container mt-2">
                                    <a href="{{ url('storage/'.$user->ktp_photo) }}">
                                        <img src="{{ asset('storage/'.$user->ktp_photo) }}" alt="Preview Foto" style="max-width: 200px; max-height: 200px;">
                                    </a>
                                </div>
                            @endif
                        </div>

                        <label for="self_ktp_photo">Foto Diri Bersama KTP</label>
                        <div class="group-input">
                            <div class="file-input-wrapper">
                                <input class="form-control @error('self_ktp_photo') is-invalid @enderror" type="file" id="self_ktp_photo" name="self_ktp_photo" accept="image/*">
                                <div class="file-name-display">
                                    <span class="self_ktp_display">{{ $user->self_ktp_photo ? basename($user->self_ktp_photo) : 'Belum ada file dipilih' }}</span>
                                </div>
                                @error('self_ktp_photo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            @if ($user->self_ktp_photo)
                                <div class="image-preview-container mt-2">
                                    <a href="{{ url('storage/'.$user->self_ktp_photo) }}">
                                        <img src="{{ asset('storage/'.$user->self_ktp_photo) }}" alt="Preview Foto" style="max-width: 200px; max-height: 200px;">
                                    </a>
                                </div>
                            @endif
                        </div>

                        <label for="kk_photo">Foto Kartu Keluaga</label>
                        <div class="group-input">
                            <div class="file-input-wrapper">
                                <input class="form-control @error('kk_photo') is-invalid @enderror" type="file" id="kk_photo" name="kk_photo" accept="image/*">
                                <div class="file-name-display">
                                    <span class="kk_display">{{ $user->kk_photo ? basename($user->kk_photo) : 'Belum ada file dipilih' }}</span>
                                </div>
                                @error('kk_photo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            @if ($user->kk_photo)
                                <div class="image-preview-container mt-2">
                                    <a href="{{ url('storage/'.$user->kk_photo) }}">
                                        <img src="{{ asset('storage/'.$user->kk_photo) }}" alt="Preview Foto" style="max-width: 200px; max-height: 200px;">
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="tf-spacing-16"></div>

                        <div class="group-input">
                            <label for="address" style="z-index: 1000">Alamat Lengkap</label>
                            <textarea name="address" id="address" class="@error('address') is-invalid @enderror" cols="30" rows="5" style="resize: vertical;" onblur="this.style.boxShadow='none'" placeholder="Cari alamat">{{ old('address', $user->address) }}</textarea>
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
                                    <option value="{{ $province->id }}" {{ $province->id == old('province_id', $user->province_id) ? 'selected="selected"' : '' }}>{{ $province->name }}</option>
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
                                    <option value="{{ $city->id }}" {{ $city->id == old('city_id', $user->city_id) ? 'selected="selected"' : '' }}>{{ $city->name }}</option>
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
                                    <option value="{{ $district->id }}" {{ $district->id == old('district_id', $user->district_id) ? 'selected="selected"' : '' }}>{{ $district->name }}</option>
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
                                    <option value="{{ $village->id }}" {{ $village->id == old('village_id', $user->village_id) ? 'selected="selected"' : '' }}>{{ $village->name }}</option>
                                @endforeach
                            </select>
                            @error('village_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="row" style="display: none">
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="latitude">Latitude</label>
                                    <input type="text" id="latitude" name="latitude" class="@error('latitude') is-invalid @enderror" value="{{ old('latitude', $user->latitude) }}" readonly>
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
                                    <input type="text" id="longitude" name="longitude" class="@error('longitude') is-invalid @enderror" value="{{ old('longitude', $user->longitude) }}" readonly>
                                    @error('longitude')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="tf-spacing-16"></div>

                        <div class="group-input">
                            <div id="map" style="height: 300px; border-radius: 8px;"></div>
                            <small class="text-muted">Klik pada peta atau geser marker untuk mengubah lokasi</small>
                        </div>

                        <div class="tf-spacing-16"></div>
                        <div class="tf-spacing-16"></div>
                        <h3 class="fw_8 mt-3" style="text-align: center;">Info Pembayaran</h3>
                        <div class="tf-spacing-16"></div>
                        <div class="tf-spacing-16"></div>

                        <div class="group-input">
                            <label for="bank" style="z-index: 100">Nama Bank</label>
                            <select style="width: 100%" name="bank" id="bank" class="@error('bank') is-invalid @enderror select2" data-live-search="true">
                                <option value="">-- Pilih Bank --</option>
                                @foreach ($banks as $bank)
                                    <option value="{{ $bank->name }}" {{ $bank->name == old('bank', $user->bank) ? 'selected="selected"' : '' }}>{{ $bank->name }}</option>
                                @endforeach
                            </select>
                            @error('bank')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="group-input">
                            <label for="account_name">Nama Pemilik Rekening</label>
                            <input type="text" class="@error('account_name') is-invalid @enderror" id="account_name" name="account_name" value="{{ old('account_name', $user->account_name) }}">
                            @error('account_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="group-input">
                            <label for="account_number">Nomor Rekening</label>
                            <input type="number" class="@error('account_number') is-invalid @enderror" id="account_number" name="account_number" value="{{ old('account_number', $user->account_number) }}">
                            @error('account_number')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="bottom-navigation-bar st2 bottom-btn-fixed" style="bottom:65px">
            <div class="tf-container">
                <button type="submit" class="tf-btn accent large">Save</button>
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
            .image-preview-container {
                margin-top: 10px;
                padding: 5px;
                border: 1px dashed #ccc;
                border-radius: 4px;
                display: inline-block;
            }
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
        </style>
    @endpush

    @push('script')
        <script>
            flatpickr(".date", {
                disableMobile: true
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

            document.addEventListener('DOMContentLoaded', function() {
                const profile_photo = document.getElementById('profile_photo');
                const profile_display = document.querySelector('.profile_display');

                profile_photo.addEventListener('change', function(e) {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();

                        profile_display.textContent = this.files[0].name;
                        profile_display.style.color = '#28a745';

                        let previewContainer = this.closest('.file-input-wrapper').nextElementSibling;
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

                const ktp_photo = document.getElementById('ktp_photo');
                const ktp_display = document.querySelector('.ktp_display');

                ktp_photo.addEventListener('change', function(e) {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();

                        ktp_display.textContent = this.files[0].name;
                        ktp_display.style.color = '#28a745';

                        let previewContainer = this.closest('.file-input-wrapper').nextElementSibling;
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

                const kk_photo = document.getElementById('kk_photo');
                const kk_display = document.querySelector('.kk_display');

                kk_photo.addEventListener('change', function(e) {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();

                        kk_display.textContent = this.files[0].name;
                        kk_display.style.color = '#28a745';

                        let previewContainer = this.closest('.file-input-wrapper').nextElementSibling;
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

                const self_ktp_photo = document.getElementById('self_ktp_photo');
                const self_ktp_display = document.querySelector('.self_ktp_display');

                self_ktp_photo.addEventListener('change', function(e) {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();

                        self_ktp_display.textContent = this.files[0].name;
                        self_ktp_display.style.color = '#28a745';

                        let previewContainer = this.closest('.file-input-wrapper').nextElementSibling;
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
        </script>
    @endpush
@endsection
