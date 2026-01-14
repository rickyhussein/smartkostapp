@extends('layouts.dashboard')
@section('button')
    <li class="nav-item mr-2">
        <a href="{{ url('/properties') }}" class="btn nav-link" style="color: red; border:1px solid red; background-color:white; ">Back</a>
    </li>
@endsection
@section('isi')
    <div class="container-fluid">
        <div class="card card-solid">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div>
                            <img style="max-height: 650px; border-radius: 15px;" src="{{ url('/storage/'.$property->photos->first()->property_file_path) }}" class="product-image" alt="Product Image">
                        </div>
                        <div class="product-image-thumbs" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 0.5rem;">
                            @php
                                $i = 0;
                            @endphp
                            @foreach ($property->photos as $photo)
                                <div class="product-image-thumb {{ $i == 0 ? 'active' : '' }}"><img src="{{ url('/storage/'.$photo->property_file_path) }}" alt="Product Image"></div>
                                @php
                                    $i += 1;
                                @endphp
                            @endforeach
                            @foreach ($property->rooms as $room)
                                <div class="product-image-thumb {{ $i == 0 ? 'active' : '' }}"><img src="{{ url('/storage/'.$room->room_file_path) }}" alt="Product Image"></div>
                                @php
                                    $i += 1;
                                @endphp
                                @foreach ($room->roomPhotos as $rp)
                                    <div class="product-image-thumb {{ $i == 0 ? 'active' : '' }}"><img src="{{ url('/storage/'.$rp->room_photo_file_path) }}" alt="Product Image"></div>
                                    @php
                                        $i += 1;
                                    @endphp
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <h3 class="my-3">{{ $property->name ?? '' }} {{ $property->village->name ? ucwords(strtolower($property->village->name)) : '' }}</h3>
                        <div class="badge mr-2 mb-2" style="color: gray; border:1px solid gray; background-color:white;"><i class="fas fa-home mr-1"></i> {{ $property->category ?? '-' }}</div>
                        <div class="badge mr-2 mb-2" style="color: gray; border:1px solid gray; background-color:white;"><i class="fas fa-map-marker-alt mr-1"></i>{{ $property->district->name ? ucwords(strtolower($property->district->name)) : '' }}</div>
                        <div class="badge mr-2 mb-2" style="color: gray; border:1px solid gray; background-color:white;"><i class="fas fa-location-arrow mr-1"></i>{{ $property->district->name ? ucwords(strtolower($property->city->name)) : '' }}</div>
                        @if ($property->status == 'Menunggu Persetujuan Admin')
                            <div class="badge mb-2" style="color: rgb(21, 47, 118); border:1px solid rgb(21, 47, 118); background-color:rgba(210, 229, 255, 0.889); border-radius:10px;">{{ $property->status ?? '-' }}</div>
                        @elseif($property->status == 'Disetujui')
                            <div class="badge mb-2" style="color: rgba(20, 78, 7, 0.889); border:1px solid rgba(20, 78, 7, 0.889); background-color:rgb(208, 255, 187); border-radius:10px;">{{ $property->status ?? '-' }}</div>
                        @else
                            <div class="badge mb-2" style="color: rgba(78, 26, 26, 0.889); border:1px solid rgba(78, 26, 26, 0.889); background-color:rgb(255, 209, 209); border-radius:10px;">{{ $property->status ?? '-' }}</div>
                        @endif

                        <hr>

                        <p>
                            <div class="float-left">
                                <b>Kos dikelola oleh</b>
                                <br>
                                {{ $property->admin_name }}
                                <br>
                                <a target="_blank" href="https://wa.me/{{ $property->whatsapp($property->admin_number) }}" class="badge mr-2" style="color: rgb(4, 149, 50); border:1px solid rgb(4, 149, 50); background-color:white; "><i class="fab fa-whatsapp"></i> Whatsapp</a>
                                <a target="_blank" href="tel:{{ $property->admin_number }}" class="badge mr-2" style="color: gray; border:1px solid gray; background-color:white; "><i class="fas fa-phone-volume"></i> Call</a>
                            </div>
                            <div class="float-right">
                                @if($property->user && $property->user->profile_photo == null)
                                    <img src="{{ url('/assets/img/foto_default.jpg') }}" alt="image" style="width: 50px; height: 50px; border-radius:50px;">
                                @else
                                    <img src="{{ url('/storage/'.$property->user->profile_photo) }}" alt="image" style="width: 50px; height: 50px; border-radius:50px;">
                                @endif
                            </div>
                        </p>

                        <br>
                        <br>
                        <br>
                        <hr>

                        <p>
                            @if ($property->latitude && $property->longitude)
                                <a href="https://www.google.com/maps?q={{ $property->latitude }},{{ $property->longitude }}" target="_blank" class="text-decoration-none">
                                    <i class="fas fa-map-marker-alt mr-1"></i> {{ $property->address }}
                                </a>
                            @else
                                <a href="https://www.google.com/maps?q={{ $property->address }}" target="_blank" class="text-decoration-none">
                                    <i class="fas fa-map-marker-alt mr-1"></i> {{ $property->address }}
                                </a>
                            @endif
                        </p>
                        <div id="map" style="height: 300px; width: 100%; margin-top: 15px;border-radius: 15px;"></div>
                        <hr>

                        @if ($property->status == 'Menunggu Persetujuan Admin')
                            <div class="row">
                                <div class="col-6">
                                    <button type="button" style="color: green; border:1px solid green; background-color:white; width:100%;" class="btn" data-toggle="modal" data-target="#approveModalCenter">
                                        <i class="fas fa-check mr-1"></i> Setuju
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button type="button" style="color: red; border:1px solid red; background-color:white; width:100%;" class="btn" data-toggle="modal" data-target="#rejectModalCenter">
                                        <i class="fas fa-times mr-1"></i> Tolak
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            <div class="row mt-4">
                <nav class="w-100">
                <div class="nav nav-tabs" id="product-tab" role="tablist">
                    <a class="nav-item nav-link active" id="product-desc-tab" data-toggle="tab" href="#product-desc" role="tab" aria-controls="product-desc" aria-selected="true">Deskripsi</a>
                    <a class="nav-item nav-link" id="product-facility-tab" data-toggle="tab" href="#product-facility" role="tab" aria-controls="product-facility" aria-selected="false">Fasilitas</a>
                    <a class="nav-item nav-link" id="product-regulation-tab" data-toggle="tab" href="#product-regulation" role="tab" aria-controls="product-regulation" aria-selected="false">Peraturan</a>
                    <a class="nav-item nav-link" id="product-room-tab" data-toggle="tab" href="#product-room" role="tab" aria-controls="product-room" aria-selected="false">Detail Kamar</a>
                    <a class="nav-item nav-link" id="product-video-tab" data-toggle="tab" href="#product-video" role="tab" aria-controls="product-video" aria-selected="false">Video</a>
                </div>
                </nav>
                <div class="tab-content p-3" id="nav-tabContent">
                <div class="tab-pane fade show active" id="product-desc" role="tabpanel" aria-labelledby="product-desc-tab">
                    {!! $property->description ? nl2br(e($property->description)) : '-' !!}
                </div>
                <div class="tab-pane fade" id="product-facility" role="tabpanel" aria-labelledby="product-facility-tab">
                    <div class="row">
                        @foreach ($property->facilities as $pf)
                            <div class="col-6">
                                <i class="fa fa-check-circle mr-1"></i>{{ $pf->facility->name ?? '-' }}
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="product-regulation" role="tabpanel" aria-labelledby="product-regulation-tab">
                    <div class="row">
                        @foreach ($property->regulations as $pr)
                            <div class="col-6">
                                <i class="fa fa-check-circle mr-1"></i>{{ $pr->regulation->name ?? '-' }}
                            </div>
                        @endforeach
                    </div>
                    @if ($property->regulation_file_path)
                        <div class="mt-4">
                            <a href="{{ url('/storage/'.$property->regulation_file_path) }}">
                                <img src="{{ url('/storage/'.$property->regulation_file_path) }}" style="max-width: 300px; max-height: 300px; border-radius: 15px;">
                            </a>
                        </div>
                    @endif
                </div>
                <div class="tab-pane fade" id="product-room" role="tabpanel" aria-labelledby="product-room-tab">
                    <div class="custom-width">
                        <center>
                            <b>Kamar Kosong</b> : {{ $property->countAvailable($property->id) }} Kamar
                        </center>
                        <br>
                        <div style="display: grid; grid-template-columns:repeat(3, 300px); gap: 0.5rem;">
                            @foreach ($property->roomAvailable($property->id) as $ra)
                                <a href="{{ url('/properties/room/show/'.$ra->id.'/'.$property->id) }}" style="color: black; text-decoration: none;">
                                    <div class="card mt-4" style="border-radius: 15px; max-width: 275px;">
                                        <img style="max-height: 150px; border-top-left-radius: 15px; border-top-right-radius: 15px; width: 100%; object-fit: cover;" src="{{ url('/storage/'.$ra->room_file_path) }}" class="card-img-top" alt="">
                                        <div class="card-body">
                                            <h5 class="card-title">Kamar {{ $ra->room_name ?? '-' }} Tipe {{ $ra->room_type ? ucwords(strtolower($ra->room_type)) : '' }}</h5>
                                            <br>
                                            <div class="badge mr-2" style="color: gray; border:1px solid gray; background-color:white; font-size:9px"><i class="fas fa-home mr-1"></i>Lantai {{ $ra->floor ?? '-' }}</div>
                                            <div class="badge mr-2" style="color: gray; border:1px solid gray; background-color:white; font-size:9px"><i class="far fa-square mr-1"></i>{{ $ra->room_height ?? '-' }} x {{ $ra->room_width ?? '-' }} Meter</div>
                                            <br>
                                            <br>
                                            <div style="font-size: 9px;">
                                                <span style="float: left;">Harga 1 Bulan</span>
                                                <span style="float: right; color: red;">Rp {{ number_format($ra->one_month_price) }}</span>
                                            </div>
                                            <br>
                                            @if ($ra->three_month_price > 0)
                                                <div style="font-size: 9px;">
                                                    <span style="float: left;">Harga 3 Bulan</span>
                                                    <span style="float: right; color: red;">Rp {{ number_format($ra->three_month_price) }}</span>
                                                </div>
                                                <br>
                                            @endif
                                            @if ($ra->six_month_price > 0)
                                                <div style="font-size: 9px;">
                                                    <span style="float: left;">Harga 6 Bulan</span>
                                                    <span style="float: right; color: red;">Rp {{ number_format($ra->six_month_price) }}</span>
                                                </div>
                                                <br>
                                            @endif
                                            @if ($ra->twelve_month_price > 0)
                                                <div style="font-size: 9px;">
                                                    <span style="float: left;">Harga 12 Bulan</span>
                                                    <span style="float: right; color: red;">Rp {{ number_format($ra->twelve_month_price) }}</span>
                                                </div>
                                                <br>
                                            @endif
                                            @if ($ra->deposit_price > 0)
                                                <div style="font-size: 9px;">
                                                    <span style="float: left;">Biaya Deposit</span>
                                                    <span style="float: right; color: red;">Rp {{ number_format($ra->deposit_price) }}</span>
                                                </div>
                                                <br>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <br>
                    <hr style="border: 2px dashed gray;" class="custom-width">
                    <div class="custom-width">
                        <center>
                            <b>Kamar Kosong</b> : {{ $property->countUnavailable($property->id) }} Kamar
                        </center>
                        <br>
                        <div style="display: grid; grid-template-columns:repeat(3, 300px); gap: 0.5rem;">
                            @foreach ($property->roomUnavailable($property->id) as $ru)
                                <a href="{{ url('/properties/room/show/'.$ru->id.'/'.$property->id) }}" style="color: black; text-decoration: none;">
                                    <div class="card mt-4" style="border-radius: 15px; max-width: 275px;">
                                        <img style="max-height: 150px; border-top-left-radius: 15px; border-top-right-radius: 15px; width: 100%; object-fit: cover;" src="{{ url('/storage/'.$ru->room_file_path) }}" class="card-img-top" alt="">
                                        <div class="card-body">
                                            <h5 class="card-title">Kamar {{ $ru->room_name ?? '-' }} Tipe {{ $ru->room_type ? ucwords(strtolower($ru->room_type)) : '' }}</h5>
                                            <br>
                                            <div class="badge mr-2" style="color: gray; border:1px solid gray; background-color:white; font-size:9px"><i class="fas fa-home mr-1"></i>Lantai {{ $ru->floor ?? '-' }}</div>
                                            <div class="badge mr-2" style="color: gray; border:1px solid gray; background-color:white; font-size:9px"><i class="far fa-square mr-1"></i>{{ $ru->room_height ?? '-' }} x {{ $ru->room_width ?? '-' }} Meter</div>
                                            <br>
                                            <br>
                                            <div style="font-size: 9px;">
                                                <span style="float: left;">Harga 1 Bulan</span>
                                                <span style="float: right; color: red;">Rp {{ number_format($ru->one_month_price) }}</span>
                                            </div>
                                            <br>
                                            @if ($ru->three_month_price > 0)
                                                <div style="font-size: 9px;">
                                                    <span style="float: left;">Harga 3 Bulan</span>
                                                    <span style="float: right; color: red;">Rp {{ number_format($ru->three_month_price) }}</span>
                                                </div>
                                                <br>
                                            @endif
                                            @if ($ru->six_month_price > 0)
                                                <div style="font-size: 9px;">
                                                    <span style="float: left;">Harga 6 Bulan</span>
                                                    <span style="float: right; color: red;">Rp {{ number_format($ru->six_month_price) }}</span>
                                                </div>
                                                <br>
                                            @endif
                                            @if ($ru->twelve_month_price > 0)
                                                <div style="font-size: 9px;">
                                                    <span style="float: left;">Harga 12 Bulan</span>
                                                    <span style="float: right; color: red;">Rp {{ number_format($ru->twelve_month_price) }}</span>
                                                </div>
                                                <br>
                                            @endif
                                            @if ($ru->deposit_price > 0)
                                                <div style="font-size: 9px;">
                                                    <span style="float: left;">Biaya Deposit</span>
                                                    <span style="float: right; color: red;">Rp {{ number_format($ru->deposit_price) }}</span>
                                                </div>
                                                <br>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="product-video" role="tabpanel" aria-labelledby="product-video-tab">
                    @if ($property->video_file_path)
                        <video style="max-width: 50%; max-height:50%" src="{{ url('/storage/'.$property->video_file_path) }}" controls></video>
                    @else
                        -
                    @endif
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="approveModalCenter" tabindex="-1" role="dialog" aria-labelledby="approveModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="approveModalLongTitle">Anda yakin untuk menyetujui properti ini?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('/properties/approve/'.$property->id) }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="admin_notes">Catatan</label>
                        <textarea name="admin_notes" id="admin_notes" class="form-control @error('admin_notes') is-invalid @enderror" rows="5">{{ old('admin_notes') }}</textarea>
                        @error('admin_notes')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
        </div>
    </div>

    <div class="modal fade" id="rejectModalCenter" tabindex="-1" role="dialog" aria-labelledby="rejectModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLongTitle">Anda yakin untuk menolak properti ini?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('/properties/reject/'.$property->id) }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="admin_notes">Catatan</label>
                        <textarea name="admin_notes" id="admin_notes" class="form-control @error('admin_notes') is-invalid @enderror" rows="5">{{ old('admin_notes') }}</textarea>
                        @error('admin_notes')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
        </div>
    </div>
    
    @push('style')
        <style>
            .custom-width {
                width: 100%;
            }
        </style>
    @endpush

    @push('script')
        <script>
            let lat = {{ $property->latitude ?? '-6.200000' }};
            let lng = {{ $property->longitude ?? '106.816666' }};
            let address = "{{ $property->address ?? 'Lokasi terpilih' }}";

            map = L.map('map').setView([lat, lng], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            marker = L.marker([lat, lng], {
                draggable: true
            }).addTo(map)
            .bindPopup(address)
            .openPopup();

            $(".clickable").on("click", function() {
                window.location.href = $(this).data("url");
            });

            $(document).ready(function() {
                $('.product-image-thumb').on('click', function () {
                    var $image_element = $(this).find('img')
                    $('.product-image').prop('src', $image_element.attr('src'))
                    $('.product-image-thumb.active').removeClass('active')
                    $(this).addClass('active')
                })
            })
        </script>
    @endpush
@endsection
