@extends('layouts.dashboard')
@section('button')
    <li class="nav-item mr-2">
        <a href="{{ url('/villages') }}" class="btn nav-link" style="color: red; border:1px solid red; background-color:white; ">Back</a>
    </li>
@endsection
@section('isi')
    <div class="container-fluid">
        <div class="card col-lg-12">
            <div class="mt-4 p-4">
                <form method="post" action="{{ url('/villages/update/'.$village->id) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-row">
                        <div class="col">
                            <label for="name">Kelurahan</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $village->name) }}" autofocus>
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
                            <label for="district_id">Kecamatan</label>
                            <select name="district_id" id="district_id" class="form-control @error('district_id') is-invalid @enderror selectpicker" data-live-search="true">
                                <option value="">-- Pilih Provinsi --</option>
                                @foreach ($districts as $district)
                                    <option value="{{ $district->id }}" {{ $district->id == old('district_id', $village->district_id) ? 'selected="selected"' : '' }}>{{ $district->name ?? '-' }}</option>
                                @endforeach
                            </select>
                            @error('district_id')
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
