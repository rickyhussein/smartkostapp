@extends('layouts.app')
@section('back')
    <a href="{{ url('/user-properties/show/'.$up->id) }}" class="back-btn"> <i class="icon-left"></i> </a>
@endsection
@section('container')
    <div id="app-wrap" class="mt-4">
        <div class="bill-content">
            <div class="tf-container">
                <span style="color: black; float: left;">Nama Properti</span>
                <span style="color: rgb(169, 169, 169); float: right;">{{ $complaint->property->name ?? '-' }} - Kamar {{ $complaint->room->room_name ?? '-' }}</span>
                <br>
                <hr style="color: rgb(150, 150, 150)">

                <span style="color: black; float: left;">Nama User</span>
                <span style="color: rgb(169, 169, 169); float: right;">{{ $complaint->user->name ?? '-' }}</span>
                <br>
                <hr style="color: rgb(150, 150, 150)">
                
                <span style="color: black; float: left;">Jenis Keluhan</span>
                <span style="color: rgb(169, 169, 169); float: right;">{{ $complaint->type ?? '-' }}</span>
                <br>
                <hr style="color: rgb(150, 150, 150)">
    
                <span style="color: black; float: left;">Tanggal</span>
                <span style="color: rgb(169, 169, 169); float: right;">
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
                </span>
                <br>
                <hr style="color: rgb(150, 150, 150)">
    
                <span style="color: black;">Keluhan</span>
                <br>
                <span style="color: rgb(169, 169, 169)">
                    {!! $complaint->complaint ? nl2br(e($complaint->complaint)) : '-' !!}
                </span>
                <hr style="color: rgb(150, 150, 150)">
    
                <span style="color: black; float: left;">File</span>
                @if ($complaint->complaint_file_path)
                    <br>
                    <div class="image-preview-container mt-2">
                        <a href="{{ url('storage/'.$complaint->complaint_file_path) }}">
                            <img src="{{ asset('storage/'.$complaint->complaint_file_path) }}" alt="Preview Foto" style="max-width: 200px; max-height: 200px;">
                        </a>
                    </div>
                @else
                    <span style="color: rgb(169, 169, 169); float: right;">-</span>
                @endif
                <br>
                <hr style="color: rgb(150, 150, 150)">
    
                <span style="color: black; float: left;">Status</span>
                <span style="color: rgb(169, 169, 169)">
                    @if ($complaint->status == 'Selesai')
                        <div class="badge" style="color: rgba(87, 169, 69, 0.889); border:1px solid rgba(87, 169, 69, 0.889); border-radius:5x; float: right;">{{ $complaint->status ?? '-' }}</div>
                    @else
                        <div class="badge" style="color: rgba(208, 43, 43, 0.889); border:1px solid rgba(208, 43, 43, 0.889);  border-radius:5x; float: right;">{{ $complaint->status ?? '-' }}</div>
                    @endif
                </span>
                <br>
                <hr style="color: rgb(150, 150, 150)">
    
                <span style="color: black">Catatan Owner</span>
                <br>
                <span style="color: rgb(169, 169, 169)">{{ $complaint->owner_note ?? '-' }}</span>
                <br>
                <hr style="color: rgb(150, 150, 150)">
    
                <span style="color: black; float: left;">Tanggal Selesai</span>
                <span style="color: rgb(169, 169, 169); float: right;">
                    @php
                        if ($complaint->solved_date) {
                            Carbon\Carbon::setLocale('id');
                            $solved_date = Carbon\Carbon::createFromFormat('Y-m-d', $complaint->solved_date);
                            $new_solved_date = $solved_date->translatedFormat('d F Y');
                        } else {
                            $new_solved_date = '-';
                        }
                    @endphp
                    {{ $new_solved_date }}
                </span>
                <br>
                <hr style="color: rgb(150, 150, 150)">
            </div>
        </div>
    </div>

    @if ($complaint->status == 'Belum Selesai')
        <div class="bottom-navigation-bar st2 bottom-btn-fixed" style="bottom:65px">
            <div class="tf-container">
                <div class="row">
                    <div class="col">
                        <a class="tf-btn small" style="color: green; border:1px solid green; background-color:white;" id="btn-popup-down"><i class="fas fa-pencil-alt"></i>Edit</a>
                    </div>
                    <div class="col">
                        <a id="btn-logout" href="#" class="tf-btn small" style="color: red; border:1px solid red; background-color:white;"><i class="fas fa-trash"></i>Hapus</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="tf-panel down">
            <div class="panel_overlay"></div>
            <div class="panel-box panel-down">
                <div class="header">
                    <div class="tf-container">
                        <div class="tf-statusbar d-flex justify-content-center align-items-center">
                            <a href="#" class="clear-panel"> <i class="icon-close1"></i> </a>
                            <h3>Edit Keluhan</h3>
                        </div>
    
                    </div>
                </div>
    
                <div class="mt-5">
                    <div class="tf-container">
                        <form class="tf-form" action="{{ url('/user-properties/complaint/update/'.$complaint->id.'/'.$up->id) }}" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            
                            <div class="group-input">
                                <label for="date">Tanggal</label>
                                <input type="date" class="date @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date', $complaint->date) }}" placeholder="yyyy-mm-dd">
                                @error('date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="group-input">
                                <label for="type" style="z-index: 100">Jenis Keluhan</label>
                                <select style="width: 100%" name="type" id="type" class="@error('type') is-invalid @enderror select2" data-live-search="true">
                                    <option value="">-- Pilih Jenis Keluhan --</option>
                                    <option value="Keluhan Alat Rusak" {{ 'Keluhan Alat Rusak' == old('type', $complaint->type) ? 'selected="selected"' : '' }}>Keluhan Alat Rusak</option>
                                    <option value="Keluhan Masalah Lingkungan" {{ 'Keluhan Masalah Lingkungan' == old('type', $complaint->type) ? 'selected="selected"' : '' }}>Keluhan Masalah Lingkungan</option>
                                </select>
                                @error('rt')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="group-input">
                                <label for="complaint">Keluhan</label>
                                <textarea name="complaint" id="complaint" class="@error('complaint') is-invalid @enderror" cols="30" rows="5" style="resize: vertical;" onblur="this.style.boxShadow='none'">{{ old('complaint', $complaint->complaint) }}</textarea>
                                @error('complaint')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <label for="complaint_file_path">File (Optional)</label>
                            <div class="group-input">
                                <div class="file-input-wrapper">
                                    <input class="form-control @error('complaint_file_path') is-invalid @enderror" type="file" id="complaint_file_path" name="complaint_file_path" accept="image/*">
                                    <div class="file-name-display">
                                        <span class="complaint_display">{{ $complaint->complaint_file_name ? basename($complaint->complaint_file_name) : 'Belum ada file dipilih' }}</span>
                                    </div>
                                    @error('complaint_file_path')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                @if ($complaint->complaint_file_path)
                                    <div class="image-preview-container mt-2">
                                        <a href="{{ url('storage/'.$complaint->complaint_file_path) }}">
                                            <img src="{{ asset('storage/'.$complaint->complaint_file_path) }}" alt="Preview Foto" style="max-width: 200px; max-height: 200px;">
                                        </a>
                                    </div>
                                @endif
                            </div>
                            
    
                            <div class="mt-7 mb-6">
                                <button type="submit" id="save" class="tf-btn accent">Save</button>
                            </div>
                        </form>

                        @push('head')
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

                        @push('foot')
                            <script>
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
                    </div>
                </div>
            </div>
        </div>

        <div class="tf-panel logout">
            <div class="panel_overlay"></div>
            <div class="panel-box panel-center panel-logout">
                <div class="heading">
                    <h2 class="text-center">Anda yakin ingin menghapus data ini?</h2>
                </div>
                <div class="bottom">
                    <a class="clear-panel" href="#">Tidak</a>
                    <a class="clear-panel critical_color" href="{{ url('/user-properties/complaint/delete/'.$complaint->id.'/'.$up->id) }}">Ya</a>
                </div>
            </div>
        </div>
    @endif

    <br>
    <br>
    <br>
    <br>
    <br>

@endsection
