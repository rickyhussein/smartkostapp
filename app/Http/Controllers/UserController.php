<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\City;
use App\Models\User;
use App\Models\Village;
use App\Models\District;
use App\Models\Province;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:users_admin', ['only' => ['index']]);
        $this->middleware('permission:profile_admin', ['only' => ['adminProfile']]);
        $this->middleware('permission:profile_user', ['only' => ['userProfile']]);
        $this->middleware('permission:profile_owner', ['only' => ['ownerProfile']]);
        $this->middleware('permission:ganti_password_admin', ['only' => ['editPasswordAdmin']]);
        $this->middleware('permission:ganti_password_owner', ['only' => ['editPasswordOwner']]);
        $this->middleware('permission:ganti_password_user', ['only' => ['editPasswordUser']]);
    }

    public function index()
    {
        $title = 'Users';
        $search = request()->input('search');
        $users = User::when($search, function ($query) use ($search) {
            $query->where('name', 'LIKE', '%'.$search.'%')
            ->orWhere('username', 'LIKE', '%'.$search.'%')
            ->orWhere('email', 'LIKE', '%'.$search.'%')
            ->orWhere('phone_number', 'LIKE', '%'.$search.'%');
        })
        ->orderBy('name', 'ASC')
        ->paginate(10)
        ->withQueryString();

        return view('users.index', compact(
            'title',
            'users'
        ));
    }

    public function create()
    {
        $title = 'Users';
        $roles = Role::orderBy('name')->get();

        return view('users.create', compact(
            'title',
            'roles'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'photo' => 'image|file|max:10240',
            'email' => 'required|unique:users',
            'phone_number' => 'required|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
        ]);

        $request->validate([
            'role' => 'required'
        ]);

        if ($request->file('photo')) {
            $validated['photo'] = $request->file('photo')->store('photo');
        }

        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);

        if ($request->role) {
            foreach($request->role as $role){
                $user->assignRole($role);
            }
        }

        return redirect('/users')->with('success', 'Data berhasil disimpan.');
    }

    public function edit($id)
    {
        $title = 'Users';
        $roles = Role::orderBy('name')->get();
        $user = User::find($id);
        $user_roles = $user->roles->pluck('name')->toArray();

        return view('users.edit', compact(
            'title',
            'roles',
            'user',
            'user_roles',
        ));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $rules = [
            'name' => 'required',
            'photo' => 'image|file|max:10240',
        ];

        if ($request->email != $user->email) {
            $rules['email'] = 'required|unique:users';
        }

        if ($request->username != $user->username) {
            $rules['username'] = 'required|unique:users';
        }

        if ($request->phone_number != $user->phone_number) {
            $rules['phone_number'] = 'required|unique:users';
        }

        $validated = $request->validate($rules);

        $request->validate([
            'role' => 'required'
        ]);

        if ($request->file('photo')) {
            $validated['photo'] = $request->file('photo')->store('photo');
        }

        $user->update($validated);

        foreach($user->roles as $r){
            $user->removeRole($r->name);
        }

        if ($request->role) {
            foreach($request->role as $role){
                $user->assignRole($role);
            }
        }

        return redirect('/users')->with('success', 'Data berhasil diubah.');
    }

    public function editPassword($id)
    {
        $title = 'Users';
        $user = User::find($id);

        return view('users.editPassword', compact(
            'title',
            'user',
        ));
    }

    public function updatePassword(Request $request, $id)
    {
        $user = User::find($id);

        $validated = $request->validate([
            'password' => 'required|min:6',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $user->update($validated);

        return redirect('/users')->with('success', 'Data berhasil dibah.');
    }

    public function delete($id)
    {
        $user = User::find($id);
        Storage::delete($user->photo);
        $user->delete();
        return redirect('/users')->with('success', 'Data berhasil dihapus.');
    }

    public function profile()
    {
        $title = 'My Profile';
        $roles = Role::orderBy('name')->get();
        $user = User::find(auth()->user()->id);
        $user_roles = $user->roles->pluck('name')->toArray();

        return view('users.profile', compact(
            'title',
            'roles',
            'user',
            'user_roles',
        ));
    }

    public function updateProfile(Request $request, $id)
    {
        $user = User::find($id);

        $rules = [
            'name' => 'required',
            'photo' => 'image|file|max:10240',
        ];

        if ($request->email != $user->email) {
            $rules['email'] = 'required|unique:users';
        }

        if ($request->username != $user->username) {
            $rules['username'] = 'required|unique:users';
        }

        if ($request->phone_number != $user->phone_number) {
            $rules['phone_number'] = 'required|unique:users';
        }

        $validated = $request->validate($rules);

        if ($request->file('photo')) {
            $validated['photo'] = $request->file('photo')->store('photo');
        }

        $user->update($validated);

        return redirect('/profile')->with('success', 'Data berhasil diupdate.');
    }

    public function ownerProfile()
    {
        $title = 'Profile';
        $user = User::find(auth()->user()->id);
        $provinces = Province::orderBy('name')->get();
        $cities = old('province_id', $user->province_id) ? City::where('province_id', old('province_id', $user->province_id))->orderBy('name')->get() : [];
        $districts = old('city_id', $user->city_id) ? District::where('city_id', old('city_id', $user->city_id))->orderBy('name')->get() : [];
        $villages = old('district_id', $user->district_id) ? Village::where('district_id', old('district_id', $user->district_id))->orderBy('name')->get() : [];
        $banks = Bank::orderBy('name')->get();

        return view('users.ownerProfile', compact(
            'title',
            'user',
            'provinces',
            'cities',
            'districts',
            'villages',
            'banks',
        ));
    }

    public function updateOwnerProfile(Request $request, $id)
    {
        $user = User::find($id);

        $rules = [
            'name' => 'required',
            'bank' => 'nullable',
            'account_name' => 'nullable',
            'account_number' => 'nullable',
            'profile_photo' => 'image|file|max:10240',
            'ktp_photo' => 'image|file|max:10240',
            'self_ktp_photo' => 'image|file|max:10240',
            'kk_photo' => 'image|file|max:10240',
            'address' => 'nullable',
            'province_id' => 'nullable',
            'city_id' => 'nullable',
            'district_id' => 'nullable',
            'village_id' => 'nullable',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
        ];

        if ($request->email != $user->email) {
            $rules['email'] = 'required|unique:users';
        }

        if ($request->phone_number != $user->phone_number) {
            $rules['phone_number'] = 'required|unique:users';
        }

        if ($request->ktp_number != $user->ktp_number) {
            $rules['ktp_number'] = 'nullable|unique:users';
        }

        $validated = $request->validate($rules);

        if ($request->file('profile_photo')) {
            $validated['profile_photo'] = $request->file('profile_photo')->store('profile_photo');
        }

        if ($request->file('ktp_photo')) {
            $validated['ktp_photo'] = $request->file('ktp_photo')->store('ktp_photo');
        }

        if ($request->file('self_ktp_photo')) {
            $validated['self_ktp_photo'] = $request->file('self_ktp_photo')->store('self_ktp_photo');
        }

        if ($request->file('kk_photo')) {
            $validated['kk_photo'] = $request->file('kk_photo')->store('kk_photo');
        }

        $user->update($validated);

        return redirect('/profile/owner')->with('success', 'Data berhasil diupdate.');
    }

    public function userProfile()
    {
        $title = 'My Profile';
        $roles = Role::orderBy('name')->get();
        $user = User::find(auth()->user()->id);
        $provinces = Province::orderBy('name')->get();
        $cities = old('province_id', $user->province_id) ? City::where('province_id', old('province_id', $user->province_id))->orderBy('name')->get() : [];
        $districts = old('city_id', $user->city_id) ? District::where('city_id', old('city_id', $user->city_id))->orderBy('name')->get() : [];
        $villages = old('district_id', $user->district_id) ? Village::where('district_id', old('district_id', $user->district_id))->orderBy('name')->get() : [];

        return view('users.userProfile', compact(
            'title',
            'roles',
            'user',
            'provinces',
            'cities',
            'districts',
            'villages',
        ));
    }

    public function updateUserProfile(Request $request, $id)
    {
        $user = User::find($id);

        $rules = [
            'name' => 'required',
            'profile_photo' => 'image|file|max:10240',
            'ktp_photo' => 'image|file|max:10240',
            'self_ktp_photo' => 'image|file|max:10240',
            'kk_photo' => 'image|file|max:10240',
            'gender' => 'nullable',
            'born_date' => 'nullable',
            'job' => 'nullable',
            'job_desc' => 'nullable',
            'status' => 'nullable',
            'last_education' => 'nullable',
            'address' => 'nullable',
            'province_id' => 'nullable',
            'city_id' => 'nullable',
            'district_id' => 'nullable',
            'village_id' => 'nullable',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
        ];

        if ($request->email != $user->email) {
            $rules['email'] = 'required|unique:users';
        }

        if ($request->phone_number != $user->phone_number) {
            $rules['phone_number'] = 'required|unique:users';
        }

        if ($request->ktp_number != $user->ktp_number) {
            $rules['ktp_number'] = 'nullable|unique:users';
        }

        $validated = $request->validate($rules);

        if ($request->file('profile_photo')) {
            $validated['profile_photo'] = $request->file('profile_photo')->store('profile_photo');
        }

        if ($request->file('ktp_photo')) {
            $validated['ktp_photo'] = $request->file('ktp_photo')->store('ktp_photo');
        }

        if ($request->file('self_ktp_photo')) {
            $validated['self_ktp_photo'] = $request->file('self_ktp_photo')->store('self_ktp_photo');
        }

        if ($request->file('kk_photo')) {
            $validated['kk_photo'] = $request->file('kk_photo')->store('kk_photo');
        }

        $user->update($validated);

        return redirect('/profile/user')->with('success', 'Data berhasil diupdate.');
    }

    public function editPasswordAdmin()
    {
        $title = 'Ganti Password';
        $user = User::find(auth()->user()->id);

        return view('users.editPasswordAdmin', compact(
            'title',
            'user',
        ));
    }

    public function editPasswordOwner()
    {
        $title = 'Ganti Password';
        $user = User::find(auth()->user()->id);

        return view('users.editPasswordOwner', compact(
            'title',
            'user',
        ));
    }

    public function editPasswordUser()
    {
        $title = 'Ganti Password';
        $user = User::find(auth()->user()->id);

        return view('users.editPasswordUser', compact(
            'title',
            'user',
        ));
    }

    public function updatePasswordAdmin(Request $request, $id)
    {
        $user = User::find($id);

        $validated = $request->validate([
            'password' => 'required|min:6',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $user->update($validated);

        return back()->with('success', 'Data berhasil diupdate.');
    }
}
