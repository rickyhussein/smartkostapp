<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:permissions_admin', ['only' => ['index']]);
    }

    public function index()
    {
        $title = 'Permissions';
        $search = request()->input('search');
        $permissions = Permission::when($search, function ($query) use ($search) {
            $query->where('name', 'LIKE', '%'.$search.'%');
        })
        ->orderBy('name', 'ASC')
        ->paginate(10)
        ->withQueryString();

        return view('permissions.index', compact(
            'title',
            'permissions'
        ));
    }

    public function create()
    {
        $title = 'Permissions';

        return view('permissions.create', compact(
            'title'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'guard_name' => 'required',
        ]);

        Permission::create($validated);

        return redirect('/permissions')->with('success', 'Data Has Been Saved.');
    }

    public function edit($id)
    {
        $title = 'Permissions';
        $permission = Permission::find($id);

        return view('permissions.edit', compact(
            'title',
            'permission'
        ));
    }

    public function update(Request $request, $id)
    {
        $permission = Permission::find($id);

        $validated = $request->validate([
            'name' => 'required',
            'guard_name' => 'required',
        ]);

        $permission->update($validated);

        return redirect('/permissions')->with('success', 'Data Has Been Updated.');
    }

    public function delete($id)
    {
        $permission = Permission::find($id);
        $permission->delete();
        return redirect('/permissions')->with('success', 'Data Has Been Deleted.');
    }
}
