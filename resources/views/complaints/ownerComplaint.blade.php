@extends('layouts.appowner')
@section('back')
    <a href="{{ url('/dashboard/owner') }}" class="back-btn"> <i class="icon-left"></i> </a>
@endsection
@section('container')
    <div id="app-wrap" class="style1">
        <div class="tf-container">
            <form action="{{ url('/complaints/owner') }}" class="mt-4">
                <div class="row">
                    <div class="col-10">
                        <input type="text" name="search" placeholder="Search.." id="search" value="{{ request('search') }}">
                    </div>
                    <div class="col-2">
                        <button type="submit" class="btn"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>

            @if (count($complaints) <= 0)
                <div class="d-flex justify-content-center align-items-center vh-100">
                    <div class="bill-content text-center">
                        <div class="tf-container">
                            <p class="m-0">Data not available</p>
                        </div>
                    </div>
                </div>
            @else
                @foreach ($complaints as $complaint)
                    <div class="ms-2 mt-4 me-2">
                        <a href="{{ url('/complaints/owner/show/'.$complaint->id) }}">
                            <div class="card mb-4" style="border-radius: 15px;">
                                <div class="card-body">
                                    <span style="color: black; float: left;">Nama Properti</span>
                                    <span style="color: rgb(169, 169, 169); float: right;">{{ $complaint->property->name ?? '-' }} - Kamar {{ $complaint->room->room_name ?? '-' }}</span>
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

                                    @if ($complaint->complaint_file_path)
                                        <span style="color: black; float: left;">File</span>
                                        <a href="{{ url('/storage/'.$complaint->complaint_file_path) }}" target="_blank" style="color: blue; float: right;"><i class="fa fa-download me-1"></i>{{ $complaint->complaint_file_name }}</a>
                                        <br>
                                        <hr style="color: rgb(150, 150, 150)">
                                    @endif

                                    <span style="color: black; float: left;">Status</span>
                                    <span style="color: rgb(169, 169, 169)">
                                        @if ($complaint->status == 'Selesai')
                                            <div class="badge" style="color: rgba(20, 78, 7, 0.889); border:1px solid rgba(20, 78, 7, 0.889); background-color:rgb(208, 255, 187); border-radius:5x; float: right;">{{ $complaint->status ?? '-' }}</div>
                                        @else
                                            <div class="badge" style="color: rgba(78, 26, 26, 0.889); border:1px solid rgba(78, 26, 26, 0.889); background-color:rgb(255, 209, 209); border-radius:5x; float: right;">{{ $complaint->status ?? '-' }}</div>
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
                                </div>
                            </div>
                        </a>
                        <div class="d-flex justify-content-end me-4 mt-4">
                            {{ $complaints->links() }}
                        </div>
                    </div>
                @endforeach
            @endif
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

    @push('script')
        <script>
            $(document).ready(function() {
                $(document).on('click', '.btn-logout', function(e) {
                    e.preventDefault();
                    const targetModal = $(this).data('target');
                    $(targetModal).addClass("panel-open");
                });

                $(document).on('click', '.panel_overlay, .clear-panel', function(e) {
                    e.preventDefault();
                    $(".logout").removeClass("panel-open");
                });

                $(".clickable").on("click", function() {
                    window.location.href = $(this).data("url");
                });
            });
        </script>
    @endpush

@endsection
