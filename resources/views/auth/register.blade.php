@extends('layouts.login')
@section('back')
    <div class="header is-fixed">
        <div class="tf-container">
            <div class="tf-statusbar d-flex justify-content-between align-items-center position-relative" style="height: 50px;">
                <div class="flex-item start" style="width: 50px; margin-top: -50px">
                    <a href="{{ url('/login') }}" class="back-btn"> <i class="icon-left"></i> </a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('container')

    <div id="app-wrap">
        <h1>Daftar Akun</h1>
        <br>
        <div class="bill-content">
            <div class="tf-container ms-1 me-1">
                <div class="row">
                    <a href="{{ url('/register/user') }}" class="col-12 mt-4">
                        <div class="card text-dark bg-light mb-3" style="border-radius: 15px;">
                            <div class="row  d-flex align-items-center">
                                <div class="col-3">
                                    <div class="ms-4 d-flex justify-content-center align-items-center text-white rounded" style="width: 50px; height: 50px;">
                                        <img src="{{ url('/assets/img/pencarikos.png') }}">
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="card-body">
                                      <h5 class="card-title">Pencari Kos</h5>
                                      <p class="card-text">Daftar sebagai pencari kos</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>

                    <a href="{{ url('/register/owner') }}" class="col-12 mt-4">
                        <div class="card text-dark bg-light mb-3" style="border-radius: 15px;">
                            <div class="row  d-flex align-items-center">
                                <div class="col-3">
                                    <div class="ms-4 d-flex justify-content-center align-items-center text-white rounded" style="width: 50px; height: 50px;">
                                        <img src="{{ url('/assets/img/ownerkos.png') }}">
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="card-body">
                                      <h5 class="card-title">Pemilik Kos</h5>
                                      <p class="card-text">Daftar sebagai pemilik kos</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="auth-line">Or</div>
    <p class="mb-9 fw-3 text-center ">Sudah punya akun? <a href="{{ url('/login') }}" class="auth-link-rg" >Masuk Disini</a></p>
@endsection
