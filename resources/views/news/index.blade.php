@extends('layouts.dashboard')
@section('button')
    <li class="nav-item mr-2">
        <a href="{{ url('/news/create') }}" class="btn btn-primary nav-link" style="color: white">+ Tambah</a>
    </li>
@endsection
@section('isi')
    <form action="{{ url('/news') }}" class="mr-2 ml-2">
        <div class="form-row mb-2">
            <div class="col-5">
                <input type="text" class="form-control" name="search" placeholder="Search.." id="search" value="{{ request('search') }}">
            </div>
            <div class="col-3">
                <input type="text" style="background-color: white;" class="form-control date" name="start_date" placeholder="Start Date" id="start_date" value="{{ request('start_date') }}">
            </div>
            <div class="col-3">
                <input type="text" style="background-color: white;" class="form-control date" name="end_date" placeholder="End Date" id="end_date" value="{{ request('end_date') }}">
            </div>
            <div class="col">
                <button type="submit" id="search" class="btn"><i class="fas fa-search"></i></button>
            </div>
        </div>
    </form>
    <div class="container-fluid">
        <div class="card p-4">
            <div class="table-responsive" style="border-radius: 10px">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" style="position: sticky; left: 0; background-color: rgb(215, 215, 215); z-index: 2;">No.</th>
                            <th style="min-width: 250px; background-color:rgb(243, 243, 243);" class="text-center">Tanggal</th>
                            <th style="min-width: 250px; background-color:rgb(243, 243, 243);" class="text-center">Judul</th>
                            <th style="min-width: 500px; background-color:rgb(243, 243, 243);" class="text-center">Isi Berita</th>
                            <th style="min-width: 250px; background-color:rgb(243, 243, 243);" class="text-center">Gambar</th>
                            <th style="min-width: 250px; background-color:rgb(243, 243, 243);" class="text-center">Created By</th>
                            <th style="min-width: 250px; background-color:rgb(243, 243, 243);" class="text-center">Updated By</th>
                            <th style="background-color:rgb(243, 243, 243);" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($news) <= 0)
                            <tr>
                                <td colspan="11" class="text-center">Tidak Ada Data</td>
                            </tr>
                        @else
                            @foreach ($news as $key => $item)
                                <tr>
                                    <td class="text-center" style="position: sticky; left: 0; background-color: rgb(235, 235, 235); z-index: 1; vertical-align: middle;">{{ ($news->currentpage() - 1) * $news->perpage() + $key + 1 }}.</td>
                                    <td class="text-center" style="vertical-align: middle;">{{ $item->date ?? '-' }}</td>
                                    <td class="text-center" style="vertical-align: middle;">{{ $item->title ?? '-' }}</td>
                                    <td style="vertical-align: middle;">{!! $item->content ? nl2br(e($item->content)) : '-' !!}</td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <img style="width: 200px;" src="{{ url('/storage/'.$item->news_file_path) }}" alt="{{ $item->judul ?? '-' }}">
                                    </td>
                                    <td class="text-center" style="vertical-align: middle;">{{ $item->createdBy->name ?? '-' }}</td>
                                    <td class="text-center" style="vertical-align: middle;">{{ $item->updatedBy->name ?? '-' }}</td>
                                    <td style="vertical-align: middle;">
                                        <div style="display: flex; gap: 5px;">
                                            <a href="{{ url('/news/edit/'.$item->id) }}" class="btn btn-primary btn-sm" style="border-radius: 10px;" title="Edit Berita"><i class="fa fa-edit"></i></a>

                                            <form action="{{ url('/news/delete/'.$item->id) }}" method="post">
                                                @method('delete')
                                                @csrf
                                                <button title="Delete Berita" class="border-0 btn btn-danger btn-sm" style="border-radius: 10px;" onClick="return confirm('Are You Sure')"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end me-4 mt-4">
                {{ $news->links() }}
            </div>
        </div>
    </div>

    @push('script')
        <script>
            flatpickr(".date", {
                disableMobile: true
            });

            $('#start_date').change(function(){
                var start_date = $(this).val();
                $('#start_date').val(start_date);
                $('#end_date').val(start_date);
            });
        </script>
    @endpush
@endsection




