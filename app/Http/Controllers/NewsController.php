<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:berita_admin', ['only' => ['index']]);
    }

    public function index()
    {
        $title = 'Berita';
        $search = request()->input('search');
        $start_date = request()->input('start_date');
        $end_date = request()->input('end_date');

        $news = News::when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
            $query->whereBetween('date', [$start_date, $end_date]);
        })
        ->when($search, function ($query) use ($search) {
            $query->where('title', 'LIKE', '%' . $search . '%')
            ->orWhere('content', 'LIKE', '%' . $search . '%');
        })
        ->orderBy('id', 'DESC')
        ->paginate(10)
        ->withQueryString();

        return view('news.index', compact(
            'title',
            'news'
        ));
    }

    public function create()
    {
        $title = 'Berita';

        return view('news.create', compact(
            'title',
        ));
    }

    public function store(Request $request)
    {
        DB::transaction(function ()  use ($request) {
            $validated = $request->validate([
                'title' => 'required',
                'content' => 'required',
                'news_file_path' => 'required|image|file|max:10240',
            ]);

            if ($request->file('news_file_path')) {
                $validated['news_file_path'] = $request->file('news_file_path')->store('news_file_path');
            }

            $validated['date'] = date('Y-m-d');
            $validated['created_by'] = auth()->user()->id;

            News::create($validated);
        });

        return redirect('/news')->with('success', 'Data Berhasil Ditambahkan');
    }

    public function edit($id)
    {
        $title = 'Berita';
        $news = News::find($id);

        return view('news.edit', compact(
            'title',
            'news',
        ));
    }

    public function update(Request $request, $id)
    {
        $news = News::find($id);

        DB::transaction(function ()  use ($request, $news) {
            $validated = $request->validate([
                'title' => 'required',
                'content' => 'required',
                'news_file_path' => 'image|file|max:10240',
            ]);

            if ($request->file('news_file_path')) {
                $validated['news_file_path'] = $request->file('news_file_path')->store('news_file_path');
            }

            $validated['updated_by'] = auth()->user()->id;
            $news->update($validated);
        });

        return redirect('/news')->with('success', 'Data Berhasil Diupdate');
    }

    public function delete($id)
    {
        $news = News::find($id);
        $news->delete();
        return redirect('/news')->with('success', 'Data Berhasil Dihapus');
    }

    public function userNews()
    {
        $title = 'Berita';
        $search = request()->input('search');

        $news = News::when($search, function ($query) use ($search) {
            $query->where('title', 'LIKE', '%' . $search . '%')
            ->orWhere('content', 'LIKE', '%' . $search . '%');
        })
        ->orderBy('id', 'DESC')
        ->paginate(10)
        ->withQueryString();

        return view('news.userNews', compact(
            'title',
            'news'
        ));
    }

    public function showUserNews($id)
    {
        $title = 'Berita';
        $news = News::find($id);

        return view('news.showUserNews', compact(
            'title',
            'news'
        ));
    }

    public function ownerNews()
    {
        $title = 'Berita';
        $search = request()->input('search');

        $news = News::when($search, function ($query) use ($search) {
            $query->where('title', 'LIKE', '%' . $search . '%')
            ->orWhere('content', 'LIKE', '%' . $search . '%');
        })
        ->orderBy('id', 'DESC')
        ->paginate(10)
        ->withQueryString();

        return view('news.ownerNews', compact(
            'title',
            'news'
        ));
    }

    public function showOwnerNews($id)
    {
        $title = 'Berita';
        $news = News::find($id);

        return view('news.showOwnerNews', compact(
            'title',
            'news'
        ));
    }
}
