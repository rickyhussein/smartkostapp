@extends('layouts.dashboard')
@section('isi')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $user_count }}</h3>

                        <p>Total Users</p>
                    </div>
                    <div class="icon">
                    </div>
                    <a href="{{ url('/users') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            
            <div class="col-lg-4 col-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{ $property_count }}</h3>

                        <p>Total Properti</p>
                    </div>
                    <div class="icon">
                    </div>
                    <a href="{{ url('/properties') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-4 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $news_count }}</h3>

                        <p>Total Berita</p>
                    </div>
                    <div class="icon">
                    </div>
                    <a href="{{ url('/news') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>


        </div>
    </div>
@endsection
