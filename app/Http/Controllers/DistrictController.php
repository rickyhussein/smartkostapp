<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\District;
use Illuminate\Http\Request;
use App\Imports\DistrictImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DistrictController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:kecamatan_admin', ['only' => ['index']]);
    }

    public function index()
    {
        $title = 'Kecamatan';
        $search = request()->input('search');

        $districts = District::when($search, function ($query) use ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%')
            ->orWhereHas('city', function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%');
            });

        })
        ->orderBy('name')
        ->paginate(10)
        ->withQueryString();

        return view('districts.index', compact(
            'title',
            'districts',
        ));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xls,xlsx,csv|max:5000'
        ]);

        $file_excel = $request->file('file_excel')->store('file_excel');

        Excel::import(new DistrictImport, public_path('/storage/'.$file_excel));
        return back()->with('success', 'Data Berhasil Di Import');
    }

    public function create()
    {
        $title = 'Kecamatan';
        $cities = City::orderBy('name')->get();

        return view('districts.create', compact(
            'title',
            'cities',
        ));
    }

    public function store(Request $request)
    {
        DB::transaction(function ()  use ($request) {
            $validated = $request->validate([
                'name' => 'required',
                'city_id' => 'required'
            ]);

            $validated['created_by'] = auth()->user()->id;
            District::create($validated);
        });

        return redirect('/districts')->with('success', 'Data Berhasil Ditambahkan');
    }

    public function edit($id)
    {
        $title = 'Kecamatan';
        $district = District::find($id);
        $cities = City::orderBy('name')->get();

        return view('districts.edit', compact(
            'title',
            'district',
            'cities',
        ));
    }

    public function update(Request $request, $id)
    {
        $district = District::find($id);

        DB::transaction(function ()  use ($request, $district) {
            $validated = $request->validate([
                'name' => 'required',
                'city_id' => 'required'
            ]);

            $validated['updated_by'] = auth()->user()->id;
            $district->update($validated);
        });

        return redirect('/districts')->with('success', 'Data Berhasil Diupdate');
    }

    public function delete($id)
    {
        $district = District::find($id);

        DB::transaction(function ()  use ($district) {
            $district->delete();
        });

        return redirect('/districts')->with('success', 'Data Berhasil Dihapus');
    }
}
