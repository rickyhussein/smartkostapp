@extends('layouts.appowner')
@section('container')
    <div class="card-secton">
        <div class="tf-container">
            <div class="tf-balance-box">
                <div class="balance">
                    <div class="row">
                        <div class="col-6 br-right">
                            <div class="inner-left">
                                <p>Sisa Saldo</p>
                                <h4>
                                    Rp {{ number_format(auth()->user()->balance) }}
                                </h4>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="inner-right">
                                <p>Total Pemasukan</p>
                                <h4>
                                    @php
                                        $total_amount = App\Models\Transaction::where('owner_id', auth()->user()->id)->where('in_out', 'in')->where('status', 'paid')->selectRaw('SUM(total_amount - owner_fee) as total')->value('total');
                                    @endphp
                                    Rp {{ number_format($total_amount) }}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="wallet-footer">
                    <ul class="d-flex justify-content-between align-items-center">
                        <li class="wallet-card-item">
                            <a href="{{ url('/profile/owner') }}" class="fw_6 text-center" >
                                <img src="{{ url('/assets/img/profile.png') }}" style="width: 45px;">
                                Profile
                            </a>
                        </li>

                        <li class="wallet-card-item">
                            <a class="fw_6" href="{{ url('/password/owner/edit') }}">
                                    <svg style="width: 45px;" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    viewBox="0 0 512 512" xml:space="preserve">
                                <circle style="fill:#273B7A;" cx="256" cy="256" r="256"/>
                                <path style="fill:#121149;" d="M512,256c0-7.982-0.384-15.87-1.098-23.666L350.594,72.027l-14.489,58.515v-7.856l-171.911,44.497
                                    l46.282,46.28l5.875,40.239l44.229,27.583l-3.644,29.018L256,444.48l60.347,60.347C428.606,477.696,512,376.596,512,256z
                                    M286.525,330.771l-0.212-0.212h0.266L286.525,330.771z"/>
                                <path style="fill:#FFFFFF;" d="M305.131,377.82c5.236,0,9.481-4.246,9.481-9.481s-4.246-9.481-9.481-9.481h-39.65v-74.867
                                    c27.826-4.546,49.131-28.743,49.131-57.835c0-32.32-26.293-58.613-58.613-58.613s-58.613,26.293-58.613,58.613
                                    c0,29.091,21.306,53.288,49.131,57.835v150.973c0,5.236,4.246,9.481,9.481,9.481c5.236,0,9.481-4.246,9.481-9.481v-8.011h39.65
                                    c5.236,0,9.481-4.246,9.481-9.481s-4.246-9.481-9.481-9.481h-39.65v-5.603h15.084c5.236,0,9.481-4.246,9.481-9.481
                                    s-4.246-9.481-9.481-9.481h-15.084v-5.603H305.131L305.131,377.82z M216.35,226.156c0-21.864,17.786-39.65,39.65-39.65
                                    s39.65,17.786,39.65,39.65s-17.786,39.65-39.65,39.65S216.35,248.018,216.35,226.156z"/>
                                <path style="fill:#D0D1D3;" d="M305.131,377.82c5.236,0,9.481-4.246,9.481-9.481s-4.246-9.481-9.481-9.481h-39.65v-74.867
                                    c27.826-4.546,49.131-28.743,49.131-57.835c0-32.32-26.293-58.613-58.613-58.613c-0.193,0-0.383,0.012-0.574,0.014v18.963
                                    c0.191-0.003,0.381-0.014,0.574-0.014c21.864,0,39.65,17.786,39.65,39.65s-17.786,39.65-39.65,39.65
                                    c-0.193,0-0.383-0.012-0.574-0.014v178.626c0.191,0.012,0.381,0.029,0.574,0.029c5.236,0,9.481-4.246,9.481-9.481v-8.011h39.65
                                    c5.236,0,9.481-4.246,9.481-9.481s-4.246-9.481-9.481-9.481h-39.65v-5.603h15.084c5.236,0,9.481-4.246,9.481-9.481
                                    s-4.246-9.481-9.481-9.481h-15.084v-5.603h39.65V377.82z"/>
                                <path style="fill:#FFC61B;" d="M341.342,68.73H170.658c-8.089,0-14.645,6.556-14.645,14.645v70.682
                                    c0,8.089,6.556,14.645,14.645,14.645h65.345l13.955,26.15c2.579,4.832,9.506,4.832,12.083,0l13.957-26.15h65.345
                                    c8.089,0,14.645-6.556,14.645-14.645V83.375C355.987,75.286,349.431,68.73,341.342,68.73z"/>
                                <path style="fill:#EAA22F;" d="M341.342,68.73h-85.916v129.708c2.56,0.21,5.222-0.976,6.616-3.587l13.955-26.15h65.345
                                    c8.089,0,14.645-6.556,14.645-14.645V83.375C355.987,75.286,349.431,68.73,341.342,68.73z"/>
                                <path style="fill:#FFEDB5;" d="M312.889,119.811H199.111c-3.332,0-6.034-2.701-6.034-6.034c0-3.332,2.701-6.034,6.034-6.034h113.778
                                    c3.332,0,6.034,2.701,6.034,6.034C318.923,117.11,316.221,119.811,312.889,119.811z"/>
                                <path style="fill:#FEE187;" d="M312.889,107.744h-57.463v12.067h57.463c3.332,0,6.034-2.701,6.034-6.034
                                    C318.923,110.445,316.221,107.744,312.889,107.744z"/>
                                </svg>
                                Ganti Password
                            </a>
                        </li>

                        <li class="wallet-card-item">
                            <a class="fw_6" href="#" id="btn-logout">
                                <svg style="width: 40px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                viewBox="0 0 512 512" xml:space="preserve">
                                <polygon style="fill:#F4A026;" points="20.677,256 188.13,383.348 175.002,294.072 371.856,294.072 371.856,215.303
                                    175.002,215.303 188.13,128.652 "/>
                                <path style="fill:#61ACD2;" d="M121.108,446.359H438.81V65.641H121.108V13.128h344.027c14.501,0,26.188,11.755,26.188,26.256
                                    v433.231c0,14.501-11.687,26.256-26.188,26.256H121.108V446.359z"/>
                                <path d="M188.131,396.476c2.299,0,4.607-0.603,6.673-1.824c4.595-2.712,7.091-7.936,6.315-13.215L190.201,307.2h182.311
                                    c7.249,0,12.472-5.879,12.472-13.128v-78.769c0-7.249-5.222-13.128-12.472-13.128H190.268l10.841-71.555
                                    c0.801-5.285-1.683-10.53-6.281-13.258c-4.597-2.725-10.39-2.395-14.646,0.842L12.729,245.55c-3.264,2.484-5.18,6.349-5.18,10.45
                                    c0,4.101,1.917,7.966,5.18,10.45l167.453,127.348C182.519,395.574,185.319,396.476,188.131,396.476z M162.013,295.982l8.447,57.433
                                    L42.365,256l127.933-97.293l-8.276,54.629c-0.574,3.782,0.53,7.626,3.026,10.526c2.493,2.901,6.128,4.569,9.954,4.569h183.727
                                    v52.513H175.002c-3.815,0-7.441,1.661-9.935,4.548C162.572,288.378,161.457,292.208,162.013,295.982z"/>
                                <path d="M465.135,0H121.764c-7.249,0-13.785,5.879-13.785,13.128v52.513c0,7.249,6.535,13.128,13.785,13.128h303.918v354.462
                                    H121.764c-7.249,0-13.785,5.879-13.785,13.128v52.513c0,7.249,6.535,13.128,13.785,13.128h343.371
                                    c22.041,0,39.316-17.668,39.316-39.385V39.385C504.451,17.668,487.176,0,465.135,0z M478.195,472.615
                                    c0,7.117-5.625,13.128-13.06,13.128H134.236v-26.256h305.231c7.249,0,12.472-5.879,12.472-13.128V65.641
                                    c0-7.249-5.222-13.128-12.472-13.128H134.236V26.256h330.899c7.435,0,13.06,6.011,13.06,13.128V472.615z"/>
                                </svg>
                                <p>Log Out</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <div class="mt-5">
        <div class="tf-container">
            <div class="tf-title d-flex justify-content-between">
                <h3 class="fw_6">Menu</h3>
            </div>
            <div class="row">
                @can('properti_owner')
                    <a href="{{ url('/properties/owner') }}" class="col-12 mt-4">
                        <div class="card text-dark bg-light mb-3" style="border-radius: 15px;">
                            <div class="row  d-flex align-items-center">
                                <div class="col-3">
                                    <div class="ms-4 d-flex justify-content-center align-items-center text-white rounded" style="width: 50px; height: 50px;">
                                        <img src="{{ url('/assets/img/pencarikos.png') }}">
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="card-body">
                                    <h5 class="card-title">Kelola Properti</h5>
                                    <p class="card-text">Kelola Kos / Kontrakan Anda</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @endcan

                <a href="{{ url('/rents/owner') }}" class="col-12 mt-4">
                    <div class="card text-dark bg-light mb-3" style="border-radius: 15px;">
                        <div class="row  d-flex align-items-center">
                            <div class="col-3">
                                <div class="ms-4 d-flex justify-content-center align-items-center text-white rounded" style="width: 50px; height: 50px;">
                                    <img src="{{ url('/assets/img/ownerkos.png') }}">
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="card-body">
                                  <h5 class="card-title">Approval Pengajuan Sewa</h5>
                                  <p class="card-text">Approval Pengajuan Sewa Dari User</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="{{ url('/withdraw/owner') }}" class="col-12 mt-4">
                    <div class="card text-dark bg-light mb-3" style="border-radius: 15px;">
                        <div class="row  d-flex align-items-center">
                            <div class="col-3">
                                <div class="ms-4 d-flex justify-content-center align-items-center text-white rounded" style="width: 50px; height: 50px;">
                                    <img src="{{ url('/assets/img/donasi5.png') }}">
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="card-body">
                                  <h5 class="card-title">Withdraw</h5>
                                  <p class="card-text">Withdraw Saldo Anda</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="{{ url('/laporan-keuangan/owner') }}" class="col-12 mt-4">
                    <div class="card text-dark bg-light mb-3" style="border-radius: 15px;">
                        <div class="row  d-flex align-items-center">
                            <div class="col-3">
                                <div class="ms-4 d-flex justify-content-center align-items-center text-white rounded" style="width: 50px; height: 50px;">
                                    <img src="{{ url('/assets/img/report.png') }}">
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="card-body">
                                  <h5 class="card-title">Laporan Keuangan</h5>
                                  <p class="card-text">Laporan Statistik Keuangan Anda</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="{{ url('/kritik-saran/owner') }}" class="col-12 mt-4">
                    <div class="card text-dark bg-light mb-3" style="border-radius: 15px;">
                        <div class="row  d-flex align-items-center">
                            <div class="col-3">
                                <div class="ms-4 d-flex justify-content-center align-items-center text-white rounded" style="width: 50px; height: 50px;">
                                    <img src="{{ url('/assets/img/kritik.png') }}">
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="card-body">
                                  <h5 class="card-title">Kritik & Saran</h5>
                                  <p class="card-text">Kritik & Saran dari Penghuni Kos Anda</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="tf-panel logout">
        <div class="panel_overlay"></div>
          <div class="panel-box panel-center panel-logout">
                <div class="heading">
                    <h2 class="text-center">Do you really want to sign out of your account?</h2>
                </div>
                <div class="bottom">
                    <a class="clear-panel" href="#">Cancel</a>
                    <a class="clear-panel critical_color" href="{{ url('/logout') }}">Log Out</a>
                </div>
          </div>
    </div>

    <div class="mt-5 mb-9">
        <div class="tf-container">
            <div class="mt-5">
                <div class="d-flex justify-content-between">
                    <h3>Berita</h3> <a href="{{ url('/news/owner') }}" class="primary_color fw_6">View All</a>
                </div>
                <div class="swiper-container banner-tes">
                    <div class="swiper-wrapper">
                        @foreach ($news as $item)
                            <div class="swiper-slide">
                                <img class="clickable" data-url="{{ url('/news/owner/show/'.$item->id) }}" style="cursor: pointer;" src="{{ url('/storage/'.$item->news_file_path) }}" alt="images">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            $(function () {
                $(".clickable").on("click", function() {
                    window.location.href = $(this).data("url");
                });
            });
        </script>
    @endpush
@endsection
