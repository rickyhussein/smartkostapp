@extends('layouts.app')
@section('back')
    <a href="{{ url('/complaints/user') }}" class="back-btn"> <i class="icon-left"></i> </a>
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

    <br>
    <br>
    <br>
    <br>
    <br>

@endsection
