@extends('layouts.app')
@section('back')
    <a href="{{ auth()->user() ? url('/dashboard/user') : url('/') }}" class="back-btn"> <i class="icon-left"></i> </a>
@endsection
@section('container')
    <div id="app-wrap" class="style1">
        <div class="tf-container">
            <form action="{{ url('/properties/user') }}" class="mt-4">
                <div class="row">
                    <div class="col-10">
                        <input type="text" name="search" placeholder="Search.." id="search" value="{{ request('search') }}">
                    </div>
                    <div class="col-2">
                        <button type="submit" class="btn"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>

            @if (count($properties) <= 0)
                <div class="d-flex justify-content-center align-items-center vh-100">
                    <div class="bill-content text-center">
                        <div class="tf-container">
                            <p class="m-0">Data not available</p>
                        </div>
                    </div>
                </div>
            @else
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.5rem;">
                    @foreach ($properties as $key => $property)
                        <a href="{{ url('/properties/user/show/'.$property->id) }}" style="color: black; text-decoration: none;">
                            <div class="card mt-4" style="border-radius: 15px; width: 100%;">
                                <img style="max-height: 150px; border-top-left-radius: 15px; border-top-right-radius: 15px; width: 100%; object-fit: cover;" src="{{ url('/storage/'.$property->photos->first()->property_file_path) }}" class="card-img-top" alt="">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $property->name ? ucwords(strtolower($property->name)) : '' }} {{ $property->village->name ? ucwords(strtolower($property->village->name)) : '' }}</h5>
                                    <div class="badge me-2" style="color: gray; border:1px solid gray; background-color:white; font-size:8px"><i class="fas fa-home me-1"></i>{{ $property->category ?? '-' }}</div>
                                    <div class="badge me-2" style="color: gray; border:1px solid gray; background-color:white; font-size:8px"><i class="fas fa-map-marker-alt me-1"></i>{{ $property->district->name ? ucwords(strtolower($property->district->name)) : '' }}</div>
                                    <br>
                                    <span style="font-style: italic; font-size:8px" class="critical_color">Sisa {{ $property->countAvailable($property->id) }} Kamar</span>
                                    <p class="text-muted" style="font-size: 8px;">
                                        @php
                                            $facility = '';
                                        @endphp
                                        @foreach ($property->facilities as $pf)
                                            @php
                                                $pemisah = !$loop->last ? ', ' : '';
                                                $facility .= $pf->facility->name . $pemisah;
                                            @endphp
                                        @endforeach
                                        {{ Str::limit($facility, 35, '...') }}
                                    </p>
                                    <p class="card-text" style="font-size: 8px;">{{ Str::limit($property->address, 60, '...') }}</p>
                                    <h6 style="font-size: 10px;" class="mt-1 critical_color">
                                        @php
                                            $price_from = $property->rooms->min('one_month_price');
                                            $price_to = $property->rooms->max('one_month_price');
                                        @endphp
                                        @if (count($property->rooms) > 1 && ($price_from != $price_to))
                                            Rp {{ number_format($price_from) }} ~ Rp {{ number_format($price_to) }} / Bulan
                                        @else
                                            Rp {{ number_format($price_from) }} / Bulan
                                        @endif
                                    </h6>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="d-flex justify-content-end me-4 mt-4">
                    {{ $properties->links() }}
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
