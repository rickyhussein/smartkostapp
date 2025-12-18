<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Province;
use App\Imports\CityImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CityController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:kota_admin', ['only' => ['index']]);
    }

    public function index()
    {
        $title = 'Kota / Kabupaten';
        $search = request()->input('search');

        $cities = City::when($search, function ($query) use ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%')
            ->orWhereHas('province', function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%');
            });

        })
        ->orderBy('name')
        ->paginate(10)
        ->withQueryString();

        return view('cities.index', compact(
            'title',
            'cities',
        ));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xls,xlsx,csv|max:5000'
        ]);

        $file_excel = $request->file('file_excel')->store('file_excel');

        Excel::import(new CityImport, public_path('/storage/'.$file_excel));
        return back()->with('success', 'Data Berhasil Di Import');
    }

    public function create()
    {
        $title = 'Kota / Kabupaten';
        $provinces = Province::orderBy('name')->get();

        return view('cities.create', compact(
            'title',
            'provinces',
        ));
    }

    public function store(Request $request)
    {
        DB::transaction(function ()  use ($request) {
            $validated = $request->validate([
                'name' => 'required',
                'province_id' => 'required'
            ]);

            $validated['created_by'] = auth()->user()->id;
            City::create($validated);
        });

        return redirect('/cities')->with('success', 'Data Berhasil Ditambahkan');
    }

    public function edit($id)
    {
        $title = 'Kota / Kabupaten';
        $city = City::find($id);
        $provinces = Province::orderBy('name')->get();

        return view('cities.edit', compact(
            'title',
            'city',
            'provinces',
        ));
    }

    public function update(Request $request, $id)
    {
        $city = City::find($id);

        DB::transaction(function ()  use ($request, $city) {
            $validated = $request->validate([
                'name' => 'required',
                'province_id' => 'required'
            ]);

            $validated['updated_by'] = auth()->user()->id;
            $city->update($validated);
        });

        return redirect('/cities')->with('success', 'Data Berhasil Diupdate');
    }

    public function delete($id)
    {
        $city = City::find($id);

        DB::transaction(function ()  use ($city) {
            $city->delete();
        });

        return redirect('/cities')->with('success', 'Data Berhasil Dihapus');
    }
}
