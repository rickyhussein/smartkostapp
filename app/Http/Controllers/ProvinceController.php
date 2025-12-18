<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;
use App\Imports\ProvinceImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ProvinceController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:provinsi_admin', ['only' => ['index']]);
    }

    public function index()
    {
        $title = 'Provinsi';
        $search = request()->input('search');

        $provinces = Province::when($search, function ($query) use ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        })
        ->orderBy('name')
        ->paginate(10)
        ->withQueryString();

        return view('provinces.index', compact(
            'title',
            'provinces',
        ));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xls,xlsx,csv|max:5000'
        ]);

        $file_excel = $request->file('file_excel')->store('file_excel');

        Excel::import(new ProvinceImport, public_path('/storage/'.$file_excel));
        return back()->with('success', 'Data Berhasil Di Import');
    }

    public function create()
    {
        $title = 'Provinsi';

        return view('provinces.create', compact(
            'title',
        ));
    }

    public function store(Request $request)
    {
        DB::transaction(function ()  use ($request) {
            $validated = $request->validate([
                'name' => 'required'
            ]);

            $validated['created_by'] = auth()->user()->id;
            Province::create($validated);
        });

        return redirect('/provinces')->with('success', 'Data Berhasil Ditambahkan');
    }

    public function edit($id)
    {
        $title = 'Provinsi';
        $province = Province::find($id);

        return view('provinces.edit', compact(
            'title',
            'province',
        ));
    }

    public function update(Request $request, $id)
    {
        $province = Province::find($id);

        DB::transaction(function ()  use ($request, $province) {
            $validated = $request->validate([
                'name' => 'required'
            ]);

            $validated['updated_by'] = auth()->user()->id;
            $province->update($validated);
        });

        return redirect('/provinces')->with('success', 'Data Berhasil Diupdate');
    }

    public function delete($id)
    {
        $province = Province::find($id);

        DB::transaction(function ()  use ($province) {
            $province->delete();
        });

        return redirect('/provinces')->with('success', 'Data Berhasil Dihapus');
    }
}
