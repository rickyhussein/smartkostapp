@extends('layouts.dashboard')
@section('isi')
    <div class="container-fluid">
        <div class="card col-lg-12">
            <div class="card-body">
                <form method="POST" action="{{ url('/profile/update/'.$user->id) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-row">
                        <div class="col-6 mb-4">
                            <label for="name">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" autofocus value="{{ old('name', $user->name) }}">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-6 mb-4">
                            <label for="photo" class="form-label">Photo</label>
                            <input class="form-control @error('photo') is-invalid @enderror" type="file" id="photo" name="photo">
                            @error('photo')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-6 mb-4">
                            <label for="email">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}">
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-6 mb-4">
                            <label for="phone_number">Phone Number</label>
                            <input type="number" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}">
                            @error('phone_number')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-12 mb-4">
                            <label for="username">Username</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username', $user->username) }}">
                            @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-12 mb-4">
                            <label for="role" class="float-left">Role</label>
                            <select style="width: 100%;" class="form-control select2 @error('role') is-invalid @enderror" id="role" name="role[]" multiple disabled>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}" {{ (is_array(old('role', $user_roles)) && in_array($role->name, old('role', $user_roles))) ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
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
