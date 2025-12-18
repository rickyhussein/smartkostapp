<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BankController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:bank_admin', ['only' => ['index']]);
    }

    public function index()
    {
        $title = 'Bank';
        $search = request()->input('search');

        $banks = Bank::when($search, function ($query) use ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        })
        ->orderBy('name')
        ->paginate(10)
        ->withQueryString();

        return view('banks.index', compact(
            'title',
            'banks',
        ));
    }

    public function create()
    {
        $title = 'Bank';

        return view('banks.create', compact(
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
            Bank::create($validated);
        });

        return redirect('/banks')->with('success', 'Data Berhasil Ditambahkan');
    }

    public function edit($id)
    {
        $title = 'Bank';
        $bank = Bank::find($id);

        return view('banks.edit', compact(
            'title',
            'bank',
        ));
    }

    public function update(Request $request, $id)
    {
        $bank = Bank::find($id);

        DB::transaction(function ()  use ($request, $bank) {
            $validated = $request->validate([
                'name' => 'required'
            ]);

            $validated['updated_by'] = auth()->user()->id;
            $bank->update($validated);
        });

        return redirect('/banks')->with('success', 'Data Berhasil Diupdate');
    }

    public function delete($id)
    {
        $bank = Bank::find($id);

        DB::transaction(function ()  use ($bank) {
            $bank->delete();
        });

        return redirect('/banks')->with('success', 'Data Berhasil Dihapus');
    }
}
