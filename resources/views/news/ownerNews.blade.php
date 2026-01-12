@extends('layouts.app')
@section('back')
    <a href="{{ url('/dashboard/owner') }}" class="back-btn"> <i class="icon-left"></i> </a>
@endsection
@section('container')
    <div id="app-wrap" class="style1">
        <div class="tf-container">
            <form action="{{ url('/news/owner') }}" class="mt-4">
                <div class="row">
                    <div class="col-10">
                        <input type="text" name="search" placeholder="Search.." id="search" value="{{ request('search') }}">
                    </div>
                    <div class="col-2">
                        <button type="submit" class="btn"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>

            @if (count($news) <= 0)
                <div class="d-flex justify-content-center align-items-center vh-100">
                    <div class="bill-content text-center">
                        <div class="tf-container">
                            <p class="m-0">Data not available</p>
                        </div>
                    </div>
                </div>
            @else
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.5rem;">
                    @foreach ($news as $key => $item)
                        <a href="{{ url('/news/owner/show/'.$item->id) }}" style="color: black; text-decoration: none;">
                            <div class="card mt-4" style="border-radius: 15px; width: 100%;">
                                <img style="max-height: 150px; border-top-left-radius: 15px; border-top-right-radius: 15px; width: 100%; object-fit: cover;" src="{{ url('/storage/'.$item->news_file_path) }}" class="card-img-top" alt="">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $item->title ? ucwords(strtolower($item->title)) : '' }}</h5>
                                    <p class="card-text">{{ Str::limit($item->content, 100, '...') }}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="d-flex justify-content-end me-4 mt-4">
                    {{ $news->links() }}
                </div>
            @endif

        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>


@endsection
