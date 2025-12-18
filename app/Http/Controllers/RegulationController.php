<?php

namespace App\Http\Controllers;

use App\Models\Regulation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegulationController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:peraturan_admin', ['only' => ['index']]);
    }

    public function index()
    {
        $title = 'Peraturan';
        $search = request()->input('search');

        $regulations = Regulation::when($search, function ($query) use ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        })
        ->orderBy('name')
        ->paginate(10)
        ->withQueryString();

        return view('regulations.index', compact(
            'title',
            'regulations',
        ));
    }

    public function create()
    {
        $title = 'Peraturan';

        return view('regulations.create', compact(
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
            Regulation::create($validated);
        });

        return redirect('/regulations')->with('success', 'Data Berhasil Ditambahkan');
    }

    public function edit($id)
    {
        $title = 'Peraturan';
        $regulation = Regulation::find($id);

        return view('regulations.edit', compact(
            'title',
            'regulation',
        ));
    }

    public function update(Request $request, $id)
    {
        $regulation = Regulation::find($id);

        DB::transaction(function ()  use ($request, $regulation) {
            $validated = $request->validate([
                'name' => 'required'
            ]);

            $validated['updated_by'] = auth()->user()->id;
            $regulation->update($validated);
        });

        return redirect('/regulations')->with('success', 'Data Berhasil Diupdate');
    }

    public function delete($id)
    {
        $regulation = Regulation::find($id);

        DB::transaction(function ()  use ($regulation) {
            $regulation->delete();
        });

        return redirect('/regulations')->with('success', 'Data Berhasil Dihapus');
    }
}
