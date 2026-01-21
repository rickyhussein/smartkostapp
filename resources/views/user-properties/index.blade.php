@extends('layouts.app')
@section('back')
    <a href="{{ url('/dashboard/user') }}" class="back-btn"> <i class="icon-left"></i> </a>
@endsection
@section('container')
    <div id="app-wrap" class="style1">
        <div class="tf-container">
            <form action="{{ url('/user-properties') }}" class="mt-4">
                <div class="row">
                    <div class="col-10">
                        <input type="text" name="search" placeholder="Search.." id="search" value="{{ request('search') }}">
                    </div>
                    <div class="col-2">
                        <button type="submit" class="btn"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>

            @if (count($user_properties) <= 0)
                <div class="d-flex justify-content-center align-items-center vh-100">
                    <div class="bill-content text-center">
                        <div class="tf-container">
                            <p class="m-0">Data not available</p>
                        </div>
                    </div>
                </div>
            @else
                @foreach ($user_properties as $key => $up)
                    <a href="{{ url('/user-properties/show/'.$up->id) }}" style="color: black; text-decoration: none;">
                        <div class="card mt-4" style="border-radius: 15px; width: 100%;">
                            <img style="max-height: 150px; border-top-left-radius: 15px; border-top-right-radius: 15px; width: 100%; object-fit: cover;" src="{{ url('/storage/'.$up->room->room_file_path) }}" class="card-img-top" alt="">
                            <div class="card-body">
                                <h5 class="card-title">{{ $up->property && $up->property->name ? ucwords(strtolower($up->property->name)) : '' }} {{ $up->property && $up->property->village && $up->property->village->name ? ucwords(strtolower($up->property->village->name)) : '' }} {{ $up->room && $up->room->room_name ? ' - Kamar ' . ucwords(strtolower($up->room->room_name)) : ''  }}</h5>
                                <div class="badge me-2" style="color: gray; border:1px solid gray; background-color:white; font-size:8px"><i class="fas fa-home me-1"></i>{{ $up->property->category ?? '-' }}</div>
                                <div class="badge me-2" style="color: gray; border:1px solid gray; background-color:white; font-size:8px"><i class="fas fa-map-marker-alt me-1"></i>{{ $up->property && $up->property->district && $up->property->district->name ? ucwords(strtolower($up->property->district->name)) : '' }}</div>
                                <div class="badge me-2" style="color: gray; border:1px solid gray; background-color:white; "><i class="far fa-square me-1"></i>{{ $up->room->room_height ?? '-' }} x {{ $up->room->room_width ?? '-' }} Meter</div>
                                @if ($up->status == 'Aktif')
                                    <div class="badge" style="color: rgba(87, 169, 69, 0.889); border:1px solid rgba(87, 169, 69, 0.889); border-radius:5x; float: right;"><i class="fa fa-check me-1"></i>{{ $up->status ?? '-' }}</div>
                                @else
                                    <div class="badge" style="color: rgba(208, 43, 43, 0.889); border:1px solid rgba(208, 43, 43, 0.889);  border-radius:5x; float: right;"><i class="fa fa-times me-1"></i>{{ $up->status ?? '-' }}</div>
                                @endif
                                <br>
                                <p class="text-muted" style="font-size: 8px;">
                                    @php
                                        $facility = '';
                                    @endphp
                                    @foreach ($up->property->facilities as $pf)
                                        @php
                                            $pemisah = !$loop->last ? ', ' : '';
                                            $facility .= $pf->facility->name . $pemisah;
                                        @endphp
                                    @endforeach
                                    {{ Str::limit($facility, 70, '...') }}
                                </p>
                                <p class="card-text" style="font-size: 8px;">{{ Str::limit($up->property->address, 150, '...') }}</p>
                                <h6 style="font-size: 10px;" class="mt-1 critical_color">
                                    @php
                                        if ($up->end_date) {
                                            Carbon\Carbon::setLocale('id');
                                            $end_date = Carbon\Carbon::createFromFormat('Y-m-d', $up->end_date);
                                            $new_end_date = $end_date->translatedFormat('d F Y');
                                        } else {
                                            $new_end_date = '-';
                                        }
                                    @endphp
                                    Berakhir pada {{ $new_end_date }}
                                </h6>
                            </div>
                        </div>
                    </a>
                @endforeach
                <div class="d-flex justify-content-end me-4 mt-4">
                    {{ $user_properties->links() }}
                </div>
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
        </script>
    @endpush

@endsection
