@extends('layouts.app')
@section('back')
    <a href="{{ url('/dashboard/user') }}" class="back-btn"> <i class="icon-left"></i> </a>
@endsection
@section('container')
    <div id="app-wrap" class="style1">
        <div class="tf-container">
            <form action="{{ url('/complaints/user') }}" class="mt-4">
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
                <ul class="mt-6">
                    @foreach ($complaints as $complaint)
                        <li class="list-card-invoice">
                            <div class="logo" style="border: 0px;">
                                @if($complaint->user && $complaint->user->profile_photo)
                                    <img src="{{ url('/storage/'.$complaint->user->profile_photo) }}" style="width: 35px; height: 35px; border-radius: 100px; object-fit: cover; margin-top: 30px;" alt="image">
                                @else
                                    <img src="{{ url('/assets/img/foto_default.jpg') }}" style="width: 35px; height: 35px; border-radius: 100px; object-fit: cover; margin-top: 30px;" alt="image">
                                @endif
                            </div>
                            <div class="content-right">
                                <h4>
                                    <a href="{{ url('/complaints/user/show/'.$complaint->id) }}">
                                        {{ $complaint->type ?? '-' }}
                                        <span class="critical_color">
                                            @if ($complaint->status == 'Selesai')
                                                <div class="badge" style="color: rgba(87, 169, 69, 0.889); border:1px solid rgba(87, 169, 69, 0.889); border-radius:5x; float: right;">{{ $complaint->status ?? '-' }}</div>
                                            @else
                                                <div class="badge" style="color: rgba(208, 43, 43, 0.889); border:1px solid rgba(208, 43, 43, 0.889);  border-radius:5x; float: right;">{{ $complaint->status ?? '-' }}</div>
                                            @endif
                                        </span>
                                    </a>
                                    <a style="font-size: 12px; font-weight:100;" href="{{ url('/complaints/user/show/'.$complaint->id) }}">
                                        {{ $complaint->user->name ?? '-' }}
                                        <br>
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
                                    </a>
                                </h4>
                            </div>
                        </li>
                    @endforeach
                    <div class="d-flex justify-content-end me-4 mt-4">
                        {{ $complaints->links() }}
                    </div>
                </ul>
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

@endsection
