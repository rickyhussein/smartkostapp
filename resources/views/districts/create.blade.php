@extends('layouts.dashboard')
@section('button')
    <li class="nav-item mr-2">
        <a href="{{ url('/districts') }}" class="btn nav-link" style="color: red; border:1px solid red; background-color:white; ">Back</a>
    </li>
@endsection
@section('isi')
    <div class="container-fluid">
        <div class="card col-lg-12">
            <div class="mt-4 p-4">
                <form method="post" action="{{ url('/districts/store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="col">
                            <label for="name">Kecamatan</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" autofocus>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="col">
                            <label for="city_id">Kota / Kabupaten</label>
                            <select name="city_id" id="city_id" class="form-control @error('city_id') is-invalid @enderror selectpicker" data-live-search="true">
                                <option value="">-- Pilih Provinsi --</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}" {{ $city->id == old('city_id') ? 'selected="selected"' : '' }}>{{ $city->name ?? '-' }}</option>
                                @endforeach
                            </select>
                            @error('city_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
@endsection
