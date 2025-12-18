@extends('layouts.appowner')
@section('back')
    <a href="{{ url('/dashboard/owner') }}" class="back-btn"> <i class="icon-left"></i> </a>
@endsection
@section('container')
    <div id="app-wrap" class="style1">
        <div class="tf-container">
            <form action="{{ url('/properties/owner') }}" class="mt-4">
                <div class="row">
                    <div class="col-10">
                        <input type="text" name="search" placeholder="Search.." id="search" value="{{ request('search') }}">
                    </div>
                    <div class="col-2">
                        <button type="submit" class="btn"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>

            @if (count($properties) <= 0)
                <div class="d-flex justify-content-center align-items-center vh-100">
                    <div class="bill-content text-center">
                        <div class="tf-container">
                            <p class="m-0">Data not available</p>
                        </div>
                    </div>
                </div>
            @else
                @foreach ($properties as $property)
                    <div class="ms-2 mt-4 me-2">
                        <a href="{{ url('/properties/owner/show/'.$property->id) }}">
                            <div class="card text-dark bg-light mb-3" style="border-radius: 15px;">
                                <div class="card-body">
                                    <div class="row  d-flex align-items-center">
                                        <div class="col-9">
                                            <h5 class="card-title" style="color: blue">{{ $property->category ?? '-' }}</h5>
                                            <h5 class="card-title">{{ $property->name ? ucwords(strtolower($property->name)) : '' }} {{ $property->village->name ? ucwords(strtolower($property->village->name)) : '' }}</h5>
                                            <p class="card-text">{!! $property->address ? nl2br(e($property->address)) : '-' !!}</p>
                                            <br>

                                            @if ($property->status == 'Menunggu Persetujuan Admin')
                                                <div class="badge mb-2" style="color: rgb(21, 47, 118); border:1px solid rgb(21, 47, 118); background-color:rgba(210, 229, 255, 0.889); border-radius:5x;">{{ $property->status ?? '-' }}</div>
                                            @elseif($property->status == 'Disetujui')
                                                <div class="badge mb-2" style="color: rgba(20, 78, 7, 0.889); border:1px solid rgba(20, 78, 7, 0.889); background-color:rgb(208, 255, 187); border-radius:5x;">{{ $property->status ?? '-' }}</div>
                                            @else
                                                <div class="badge mb-2" style="color: rgba(78, 26, 26, 0.889); border:1px solid rgba(78, 26, 26, 0.889); background-color:rgb(255, 209, 209); border-radius:5x;">{{ $property->status ?? '-' }}</div>
                                            @endif
                                        </div>
                                        <div class="col-3">
                                            <div class="d-flex justify-content-center align-items-center text-white rounded">
                                                <img src="{{ url('/storage/'.$property->photos->first()->property_file_path) }}" style="width: 70px; height: 70px; border-radius: 15px; object-fit: cover;" alt="Kos Image">
                                            </div>
                                        </div>
                                    </div>
                                    @if ($property->admin_notes)
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">Catatan Admin:</h5>
                                                <p>{!! $property->admin_notes ? nl2br(e($property->admin_notes)) : '-' !!}</p>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($property->status == 'Menunggu Persetujuan Admin' || $property->status == 'Ditolak')
                                        <hr>
                                        <div class="row">
                                            <div class="col-6 mb-4">
                                                <a class="tf-btn small" style="color: green; border:1px solid green; background-color:white;" href="{{ url('/properties/owner/edit/'.$property->id) }}"><i class="fas fa-pencil-alt"></i>Edit</a>
                                            </div>

                                            <div class="col-6 mb-4">
                                                <a href="#" class="tf-btn small btn-logout" style="color: red; border:1px solid red; background-color:white;" data-target="#logoutModal-{{ $property->id }}"><i class="fas fa-trash"></i>Hapus</a>
                                            </div>

                                            <div class="tf-panel logout" id="logoutModal-{{ $property->id }}">
                                                <div class="panel_overlay"></div>
                                                <div class="panel-box panel-center panel-logout">
                                                    <div class="heading">
                                                        <h2 class="text-center">Anda yakin ingin menghapus data ini?</h2>
                                                    </div>
                                                    <div class="bottom">
                                                        <a class="clear-panel" href="#">Cancel</a>
                                                        <a class="clear-panel critical_color clickable" data-url="{{ url('/properties/owner/delete/'.$property->id) }}" style="cursor: pointer;">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </a>
                        <div class="d-flex justify-content-end me-4 mt-4">
                            {{ $properties->links() }}
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <div class="bottom-navigation-bar st2 bottom-btn-fixed" style="bottom:50px">
        <div class="tf-container">
            <a href="{{ url('/properties/owner/create') }}" class="tf-btn accent large"> + Tambah</a>
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

    @push('script')
        <script>
            $(document).ready(function() {
                $(document).on('click', '.btn-logout', function(e) {
                    e.preventDefault();
                    const targetModal = $(this).data('target');
                    $(targetModal).addClass("panel-open");
                });

                $(document).on('click', '.panel_overlay, .clear-panel', function(e) {
                    e.preventDefault();
                    $(".logout").removeClass("panel-open");
                });

                $(".clickable").on("click", function() {
                    window.location.href = $(this).data("url");
                });
            });
        </script>
    @endpush

@endsection
