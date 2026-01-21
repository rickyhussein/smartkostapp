@extends('layouts.app')
@section('back')
    <a href="{{ url('/dashboard/user') }}" class="back-btn"> <i class="icon-left"></i> </a>
@endsection
@section('container')
    <div id="app-wrap" class="style1">
        <div class="tf-container">
            <form action="{{ url('/transactions/user') }}" class="mt-4">
                <div class="row">
                    <div class="col-10">
                        <input type="text" name="search" placeholder="Search.." id="search" value="{{ request('search') }}">
                    </div>
                    <div class="col-2">
                        <button type="submit" class="btn"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>

            @if (count($transactions) <= 0)
                <div class="d-flex justify-content-center align-items-center vh-100">
                    <div class="bill-content text-center">
                        <div class="tf-container">
                            <p class="m-0">Data not available</p>
                        </div>
                    </div>
                </div>
            @else
                <ul class="mt-6">
                    @foreach ($transactions as $transaction)
                        <li class="list-card-invoice">
                            <div class="logo">
                                @if ($transaction->status == 'paid')
                                    <img src="{{ url('/assets/img/success.png') }}" style="width: 30px; height: 30px; border-radius: 100px; object-fit: cover;">
                                @else
                                    <img src="{{ url('/assets/img/failed.png') }}" style="width: 40px; height: 40px; border-radius: 100px; object-fit: cover;">
                                @endif
                            </div>
                            <div class="content-right">
                                <h4>
                                    <a href="{{ url('/transactions/user/show/'.$transaction->id) }}">
                                        {{ $transaction->type ?? '-' }}
                                        <span class="critical_color">
                                            @if ($transaction->status == 'paid')
                                                <div class="badge" style="color: rgba(87, 169, 69, 0.889); border:1px solid rgba(87, 169, 69, 0.889); border-radius:5x; float: right;">{{ $transaction->status ?? '-' }}</div>
                                            @else
                                                <div class="badge" style="color: rgba(208, 43, 43, 0.889); border:1px solid rgba(208, 43, 43, 0.889);  border-radius:5x; float: right;">{{ $transaction->status ?? '-' }}</div>
                                            @endif
                                        </span>
                                    </a>
                                    <a style="font-size: 12px; font-weight:100;" href="{{ url('/transactions/user/show/'.$transaction->id) }}">
                                        {{ $transaction->user->name ?? '-' }}
                                        <br>
                                        @php
                                            if ($transaction->date) {
                                                Carbon\Carbon::setLocale('id');
                                                $transaction_date = Carbon\Carbon::createFromFormat('Y-m-d', $transaction->date);
                                                $new_complaint_date = $transaction_date->translatedFormat('d F Y');
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
                        {{ $transactions->links() }}
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
