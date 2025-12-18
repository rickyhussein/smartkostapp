<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:roles_admin', ['only' => ['index']]);
    }

    public function index()
    {
        $title = 'Roles';
        $search = request()->input('search');
        $roles = Role::when($search, function ($query) use ($search) {
            $query->where('name', 'LIKE', '%'.$search.'%');
        })
        ->orderBy('name', 'ASC')
        ->paginate(10)
        ->withQueryString();

        return view('roles.index', compact(
            'title',
            'roles'
        ));
    }

    public function create()
    {
        $title = 'Roles';
        $permissions = Permission::orderBy('name')->get();

        return view('roles.create', compact(
            'title',
            'permissions',
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'guard_name' => 'required',
            'permission' => 'required',
        ]);

        $role = Role::create([
            'name' => $request->input('name'),
            'guard_name' => $request->input('guard_name'),
        ]);

        $role->syncPermissions($request->input('permission'));

        return redirect('/roles')->with('success', 'Data Has Been Saved.');
    }

    public function edit($id)
    {
        $title = 'Roles';
        $role = Role::find($id);
        $permissions = Permission::orderBy('name')->get();
        $role_permission = DB::table('role_has_permissions')->where('role_id', $id)->pluck('permission_id')->toArray();

        return view('roles.edit', compact(
            'title',
            'role',
            'permissions',
            'role_permission',
        ));
    }

    public function update(Request $request, $id)
    {
        $role = Role::find($id);

        $request->validate([
            'name' => 'required',
            'guard_name' => 'required',
            'permission' => 'required',
        ]);

        $role->update([
            'name' => $request->input('name'),
            'guard_name' => $request->input('guard_name'),
        ]);

        $role->syncPermissions($request->input('permission'));

        return redirect('/roles')->with('success', 'Data Has Been Updated.');
    }

    public function delete($id)
    {
        $role = Role::find($id);
        $role->delete();
        return redirect('/roles')->with('success', 'Data Has Been Deleted.');
    }
}
