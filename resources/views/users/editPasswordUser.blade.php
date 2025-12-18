@extends('layouts.app')
@section('back')
    <a href="{{ url('/dashboard/user') }}" class="back-btn"> <i class="icon-left"></i> </a>
@endsection
@section('container')
    <form class="tf-form" action="{{ url('/password/update/'.$user->id) }}" enctype="multipart/form-data" method="POST">
        @method('PUT')
        @csrf
        <div id="app-wrap" class="mt-4">
            <div class="bill-content">
                <div class="repicient-content">
                <div class="tf-container">
                    <div class="box-user mt-5 text-center">
                        <div class="box-avatar">
                            @if($user->profile_photo == null)
                                <img src="{{ url('/assets/img/foto_default.jpg') }}" alt="image">
                            @else
                                <img src="{{ url('/storage/'.$user->profile_photo) }}" alt="image">
                            @endif
                        </div>
                        <h3 class="fw_8 mt-3">{{ strtoupper($user->name) }}</h3>
                    </div>
                </div>
                </div>
                <div class="tf-container ms-4 me-4">
                    <div class="card-secton transfer-section mt-2">
                        <div class="tf-spacing-20"></div>
                        <div class="group-input">
                            <label for="password" class="float-left">Password Baru</label>
                            <input type="password" class="@error('password') is-invalid @enderror" id="password" name="password">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bottom-navigation-bar st2 bottom-btn-fixed" style="bottom:65px">
            <div class="tf-container">
                <button type="submit" class="tf-btn accent large">Save</button>
            </div>
        </div>
    </form>

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
