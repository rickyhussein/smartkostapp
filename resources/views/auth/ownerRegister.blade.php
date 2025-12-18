@extends('layouts.login')
@section('back')
    <div class="header is-fixed">
        <div class="tf-container">
            <div class="tf-statusbar d-flex justify-content-between align-items-center position-relative" style="height: 50px;">
                <div class="flex-item start" style="width: 50px; margin-top: -50px">
                    <a href="{{ url('/register') }}" class="back-btn"> <i class="icon-left"></i> </a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('container')
    <div id="app-wrap">
        <h2>Daftar akun pemilik kos</h2>
        <br>
        <br>
        <form id="form-register" class="tf-form" action="{{ url('/register/owner/store') }}" method="POST">
            @csrf
            <div class="group-input">
                <label>Nama Lengkap</label>
                <input type="text" placeholder="Nama Lengkap" class="@error('name') is-invalid @enderror" value="{{ old('name') }}" name="name">
                @error('name')
                  <div class="invalid-feedback">
                      {{ $message }}
                  </div>
                @enderror
            </div>
            <div class="group-input">
                <label>Email</label>
                <input type="email" placeholder="email" class="@error('email') is-invalid @enderror" value="{{ old('email') }}" name="email">
                @error('email')
                  <div class="invalid-feedback">
                      {{ $message }}
                  </div>
                @enderror
            </div>
            <div class="group-input">
                <label>Nomor Handphone</label>
                <input type="number" placeholder="Nomor Handphone" class="@error('phone_number') is-invalid @enderror" value="{{ old('phone_number') }}" name="phone_number">
                @error('phone_number')
                  <div class="invalid-feedback">
                      {{ $message }}
                  </div>
                @enderror
            </div>
            <div class="group-input auth-pass-input last">
                <label>Password</label>
                <input type="password" class="password-input @error('password') is-invalid @enderror" placeholder="Password" name="password">
                <a class="icon-eye password-addon" id="password-addon"></a>
                @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="group-input auth-pass-input last mt-4">
                <label>Konfirmasi Password</label>
                <input type="password" class="password-input @error('password') is-invalid @enderror" placeholder="Konfirmasi Password" name="password_confirmation">
                <a class="icon-eye password-addon" id="password-addon"></a>
                @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <button type="submit" class="tf-btn accent large">Daftar</button>
        </form>
    </div>

    <div class="auth-line">Or</div>
    <p class="mb-9 fw-3 text-center ">Sudah punya akun? <a href="{{ url('/login') }}" class="auth-link-rg" >Masuk Disini</a></p>
@endsection
