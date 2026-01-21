@extends('layouts.appowner')
@section('back')
    <a href="{{ url('/complaints/owner') }}" class="back-btn"> <i class="icon-left"></i> </a>
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
                <a style="color: rgb(255, 135, 36); border:1px solid rgb(255, 135, 36); " id="btn-popup-down" class="tf-btn large" disabled>Approval</a>
            </div>
        </div>
        
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
                        <form class="tf-form" action="{{ url('/complaints/owner/approval/'.$complaint->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="group-input">
                                <label for="status" style="z-index: 1000;">Status</label>
                                <select style="width: 100%" name="status" id="status" class="select2 @error('status') is-invalid @enderror">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="Selesai" {{ 'Selesai' == old('status') ? 'selected="selected"' : '' }}>Selesai</option>
                                    <option value="Belum Selesai" {{ 'Belum Selesai' == old('status') ? 'selected="selected"' : '' }}>Belum Selesai</option>
                                </select>
                                @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="group-input">
                                <label for="solved_date">Tanggal Selesai</label>
                                <input type="date" class="date @error('solved_date') is-invalid @enderror" id="solved_date" name="solved_date" value="{{ old('solved_date', $complaint->solved_date) }}" placeholder="yyyy-mm-dd">
                                @error('solved_date')
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

                        @push('foot')
                            <script>
                                flatpickr(".date", {
                                    disableMobile: true
                                });
                            </script>
                        @endpush
                    </div>
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
