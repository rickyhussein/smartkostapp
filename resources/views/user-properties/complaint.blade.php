@extends('layouts.app')

@section('back')
    <a href="{{ url('/user-properties/show/'.$up->id) }}" class="back-btn"> <i class="icon-left"></i> </a>
@endsection

@section('container')
    <form class="tf-form" action="{{ url('/user-properties/complaint/store/'.$up->id) }}" enctype="multipart/form-data" method="POST">
        <div id="app-wrap" class="mt-4">
            <div class="bill-content">
                <div class="card-secton transfer-section mt-2">
                    <div class="tf-container ms-2 me-2">
                        @csrf
                        <div class="group-input">
                            @php
                                $property_name = $property->name ? ucwords(strtolower($property->name)) : '';
                                $room_name = $room->room_name ? ucwords(strtolower($room->room_name)) : '';
                            @endphp
                            <label for="name">Nama Properti</label>
                            <input type="text" class="@error('property_name') is-invalid @enderror" id="property_name" name="property_name" value="{{ old('property_name', $property->name . ' - Kamar ' . $room_name) }}" readonly>
                            @error('property_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="group-input">
                            <div class="group-input">
                                <label for="date">Tanggal</label>
                                <input type="date" class="date @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date', date('Y-m-d')) }}" placeholder="yyyy-mm-dd">
                                @error('date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="group-input">
                            <label for="type" style="z-index: 100">Jenis Keluhan</label>
                            <select style="width: 100%" name="type" id="type" class="@error('type') is-invalid @enderror select2" data-live-search="true">
                                <option value="">-- Pilih Jenis Keluhan --</option>
                                <option value="Keluhan Alat Rusak" {{ 'Keluhan Alat Rusak' == old('type') ? 'selected="selected"' : '' }}>Keluhan Alat Rusak</option>
                                <option value="Keluhan Masalah Lingkungan" {{ 'Keluhan Masalah Lingkungan' == old('type') ? 'selected="selected"' : '' }}>Keluhan Masalah Lingkungan</option>
                            </select>
                            @error('rt')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="group-input">
                            <label for="complaint">Keluhan</label>
                            <textarea name="complaint" id="complaint" class="@error('complaint') is-invalid @enderror" cols="30" rows="5" style="resize: vertical;" onblur="this.style.boxShadow='none'" placeholder="Ceritakan hal yang menarik tentang Kos Anda">{{ old('complaint') }}</textarea>
                            @error('complaint')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <label for="complaint_file_path">File (Optional)</label>
                        <div class="group-input">
                            <div class="file-input-wrapper">
                                <input class="form-control @error('complaint_file_path') is-invalid @enderror" type="file" id="complaint_file_path" name="complaint_file_path">
                                <div class="file-name-display">
                                    <span class="complaint_display">Belum ada file dipilih</span>
                                </div>
                                @error('complaint_file_path')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

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
        </style>
    @endpush

    @push('script')
        <script>
            $('.select2').select2();

            flatpickr(".date", {
                disableMobile: true
            });
            
            document.addEventListener('DOMContentLoaded', function() {
                const complaint_file_path = document.getElementById('complaint_file_path');
                const complaint_display = document.querySelector('.complaint_display');

                complaint_file_path.addEventListener('change', function(e) {
                    if (this.files && this.files[0]) {
                        const file = this.files[0];
                        const maxSize = 5 * 1024 * 1024;

                        if (file.size > maxSize) {
                            alert("Ukuran file maksimal 5MB!");
                            this.value = "";
                            complaint_display.textContent = "Belum ada file dipilih";
                            complaint_display.style.color = "#dc3545";
                            return;
                        }

                        const reader = new FileReader();
                        complaint_display.textContent = file.name;
                        complaint_display.style.color = '#28a745';

                        let previewContainer = this.closest('.group-input').querySelector('.image-preview-container');
                        if (!previewContainer) {
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

                        reader.readAsDataURL(file);
                    }
                });
            });
        </script>
    @endpush
@endsection
