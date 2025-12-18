<?php

namespace App\Http\Controllers;

use App\Models\Village;
use App\Models\District;
use Illuminate\Http\Request;
use App\Imports\VillageImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class VillageController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:kelurahan_admin', ['only' => ['index']]);
    }

    public function index()
    {
        $title = 'Kelurahan';
        $search = request()->input('search');

        $villages = Village::when($search, function ($query) use ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%')
            ->orWhereHas('district', function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%');
            });

        })
        ->orderBy('name')
        ->paginate(10)
        ->withQueryString();

        return view('villages.index', compact(
            'title',
            'villages',
        ));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xls,xlsx,csv|max:5000'
        ]);

        $file_excel = $request->file('file_excel')->store('file_excel');

        Excel::import(new VillageImport, public_path('/storage/'.$file_excel));
        return back()->with('success', 'Data Berhasil Di Import');
    }

    public function create()
    {
        $title = 'Kelurahan';
        $districts = District::orderBy('name')->get();

        return view('villages.create', compact(
            'title',
            'districts',
        ));
    }

    public function store(Request $request)
    {
        DB::transaction(function ()  use ($request) {
            $validated = $request->validate([
                'name' => 'required',
                'district_id' => 'required'
            ]);

            $validated['created_by'] = auth()->user()->id;
            Village::create($validated);
        });

        return redirect('/villages')->with('success', 'Data Berhasil Ditambahkan');
    }

    public function edit($id)
    {
        $title = 'Kelurahan';
        $village = Village::find($id);
        $districts = District::orderBy('name')->get();

        return view('villages.edit', compact(
            'title',
            'village',
            'districts',
        ));
    }

    public function update(Request $request, $id)
    {
        $village = Village::find($id);

        DB::transaction(function ()  use ($request, $village) {
            $validated = $request->validate([
                'name' => 'required',
                'district_id' => 'required'
            ]);

            $validated['updated_by'] = auth()->user()->id;
            $village->update($validated);
        });

        return redirect('/villages')->with('success', 'Data Berhasil Diupdate');
    }

    public function delete($id)
    {
        $village = Village::find($id);

        DB::transaction(function ()  use ($village) {
            $village->delete();
        });

        return redirect('/villages')->with('success', 'Data Berhasil Dihapus');
    }
}
