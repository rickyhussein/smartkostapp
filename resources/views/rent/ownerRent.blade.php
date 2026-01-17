@extends('layouts.appowner')
@section('back')
    <a href="{{ url('/dashboard/owner') }}" class="back-btn"> <i class="icon-left"></i> </a>
@endsection
@section('container')
    <div id="app-wrap" class="style1">
        <div class="tf-container">
            <form action="{{ url('/rent/owner') }}" class="mt-4">
                <div class="row">
                    <div class="col-10">
                        <input type="text" name="search" placeholder="Search.." id="search" value="{{ request('search') }}">
                    </div>
                    <div class="col-2">
                        <button type="submit" class="btn"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>

            @if (count($rents) <= 0)
                <div class="d-flex justify-content-center align-items-center vh-100">
                    <div class="bill-content text-center">
                        <div class="tf-container">
                            <p class="m-0">Data not available</p>
                        </div>
                    </div>
                </div>
            @else
                @foreach ($rents as $rent)
                    <div class="mt-4">
                        <a href="{{ url('/rent/owner/show/'.$rent->id) }}">
                            <div class="card text-dark bg-light mb-3" style="border-radius: 15px;">
                                <div class="card-body">
                                    <div class="row  d-flex align-items-center">
                                        <div class="col-4">
                                        <img src="{{ url('/storage/'.$rent->property->photos->first()->property_file_path) }}" alt="image" style="max-height: 70px; border-radius:10px;">
                                    </div>
                                    <div class="col-8">
                                        @php
                                            $kos_title = $rent->property->name . ' ' . $rent->property->type;
                                        @endphp
                                        {{ $kos_title }}
                                        <br>
                                        {{ $rent->property->district->name ?? '' }} - {{ $rent->property->city->name ?? '' }}
                                        <br>
                                        <p>Penyewa : <span style="font-weight: bold">{{ $rent->user->name }}</span></p>
                                        @php
                                            $facility = '';
                                        @endphp
                                        @foreach ($rent->property->facilities as $pf)
                                            @php
                                                $pemisah = !$loop->last ? ', ' : '';
                                                $facility .= $pf->facility->name . $pemisah;
                                            @endphp
                                        @endforeach
                                        <span style="color: rgb(169, 169, 169)">{{ Str::limit($facility, 32, '...') }}</span>
                                        <h6 style="font-size: 10px;" class="mt-1">Rp {{ number_format($rent->total_amount) }}</h6>
                                        @if ($rent->status == 'Menunggu Persetujuan Owner')
                                            <div class="badge" style="color: rgb(21, 47, 118); border:1px solid rgb(21, 47, 118); background-color:rgba(210, 229, 255, 0.889); border-radius:5x;">{{ $rent->status ?? '-' }}</div>
                                        @elseif($rent->status == 'Disetujui')
                                            <div class="badge" style="color: rgba(20, 78, 7, 0.889); border:1px solid rgba(20, 78, 7, 0.889); background-color:rgb(208, 255, 187); border-radius:5x;">{{ $rent->status ?? '-' }}</div>
                                        @else
                                            <div class="badge" style="color: rgba(78, 26, 26, 0.889); border:1px solid rgba(78, 26, 26, 0.889); background-color:rgb(255, 209, 209); border-radius:5x;">{{ $rent->status ?? '-' }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="d-flex justify-content-end me-4 mt-4">
                            {{ $rents->links() }}
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
