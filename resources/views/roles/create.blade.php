@extends('layouts.dashboard')
@section('button')
    <li class="nav-item mr-2">
        <a href="{{ url('/roles') }}" class="btn nav-link" style="color: red; border:1px solid red; background-color:white; ">Back</a>
    </li>
@endsection
@section('isi')
    <div class="container-fluid">
        <div class="card col-lg-12">
            <div class="card-body">
                <form method="POST" action="{{ url('/roles/store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="col-6 mb-4">
                            <label for="name">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" autofocus value="{{ old('name') }}">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-6 mb-4">
                            <label for="guard_name">Guard</label>
                            <input type="text" class="form-control @error('guard_name') is-invalid @enderror" id="guard_name" name="guard_name" autofocus value="{{ old('guard_name', 'web') }}" readonly>
                            @error('guard_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-12 mb-4">
                            <label for="permission" class="float-left">Permission</label>
                            <select style="width: 100%;" class="form-control select2 @error('permission') is-invalid @enderror" id="permission" name="permission[]" multiple>
                                @foreach ($permissions as $permission)
                                    <option value="{{ $permission->id }}" {{ (is_array(old('permission')) && in_array($permission->id, old('permission'))) ? 'selected' : '' }}>
                                        {{ $permission->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('permission')
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

    @push('script')
        <script>
            $('.select2').select2();
        </script>
    @endpush
@endsection
