@extends('layouts.dashboard')
@section('button')
    <li class="nav-item mr-2">
        <a href="{{ url('/permissions') }}" class="btn nav-link" style="color: red; border:1px solid red; background-color:white; ">Back</a>
    </li>
@endsection
@section('isi')
    <div class="container-fluid">
        <div class="card col-lg-12">
            <div class="card-body">
                <form method="POST" action="{{ url('/permissions/update/'.$permission->id) }}" enctype="multipart/form-data">
                    @method("PUT")
                    @csrf
                    <div class="form-row">
                        <div class="col-12 mb-4">
                            <label for="name">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" autofocus value="{{ old('name', $permission->name) }}">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-12 mb-4">
                            <label for="guard_name">Guard</label>
                            <input type="text" class="form-control @error('guard_name') is-invalid @enderror" id="guard_name" name="guard_name" autofocus value="{{ old('guard_name', $permission->guard_name) }}" readonly>
                            @error('guard_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
@endsection
