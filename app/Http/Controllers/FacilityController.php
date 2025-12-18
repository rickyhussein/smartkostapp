<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacilityController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:fasilitas_admin', ['only' => ['index']]);
    }

    public function index()
    {
        $title = 'Fasilitas';
        $search = request()->input('search');

        $facilities = Facility::when($search, function ($query) use ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        })
        ->orderBy('name')
        ->paginate(10)
        ->withQueryString();

        return view('facilities.index', compact(
            'title',
            'facilities',
        ));
    }

    public function create()
    {
        $title = 'Fasilitas';

        return view('facilities.create', compact(
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
            Facility::create($validated);
        });

        return redirect('/facilities')->with('success', 'Data Berhasil Ditambahkan');
    }

    public function edit($id)
    {
        $title = 'Fasilitas';
        $facility = Facility::find($id);

        return view('facilities.edit', compact(
            'title',
            'facility',
        ));
    }

    public function update(Request $request, $id)
    {
        $facility = Facility::find($id);

        DB::transaction(function ()  use ($request, $facility) {
            $validated = $request->validate([
                'name' => 'required'
            ]);

            $validated['updated_by'] = auth()->user()->id;
            $facility->update($validated);
        });

        return redirect('/facilities')->with('success', 'Data Berhasil Diupdate');
    }

    public function delete($id)
    {
        $facility = Facility::find($id);

        DB::transaction(function ()  use ($facility) {
            $facility->delete();
        });

        return redirect('/facilities')->with('success', 'Data Berhasil Dihapus');
    }
}
