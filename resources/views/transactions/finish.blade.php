<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>
    <link rel="shortcut icon" href="{{ url('/assets/img/kos.png') }}" />
    <link rel="apple-touch-icon-precomposed" href="{{ url('/assets/img/kos.png') }}" />
    <link rel="stylesheet" href="{{ url('/myhr/fonts/fonts.css') }}" />
    <link rel="stylesheet" href="{{ url('/myhr/fonts/icons-alipay.css') }}">
    <link rel="stylesheet" href="{{ url('/myhr/styles/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ url('/myhr/styles/swiper-bundle.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/myhr/styles/styles.css') }}" />
    <link rel="manifest" href="{{ url('/manifest.json') }}" data-pwa-version="set_in_manifest_and_pwa_js">
    <link rel="apple-touch-icon" sizes="192x192" href="{{ url('/icons/icon-192.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="{{ url('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ url('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css" integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js" integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ==" crossorigin=""></script>
</head>

<body>
    
    <div class="preload preload-container">
        <div class="preload-logo">
            <div class="spinner"></div>
        </div>
    </div>
    <div class="wrap-success">

        @php
            if ($transaction_status == 'settlement' || $transaction_status == 'capture') {
                $status = 'Berhasil';
            } else if ($transaction_status == 'pending') {
                $status = 'Menunggu Pembayaran';
            } else if ($transaction_status == 'deny') {
                $status = 'Ditolak';
            } else if ($transaction_status == 'cancel') {
                $status = 'Dibatalkan';
            } else if ($transaction_status == 'expire') {
                $status = 'Kadaluarsa';
            } else {
                $status = 'Gagal';
            }

            if ($transaction->up_id) {
                $url = url('/user-properties/show/'.$transaction->up_id);
            } else {
                $url = url('/rents/user/show/'.$transaction->rent_id);
            }
            
        @endphp
        
        <div class="success_box">
            <div class="icon-1 ani3">
                @if ($transaction_status == 'settlement' || $transaction_status == 'capture')
                    <span class="circle-box lg bg-circle check-icon"></span>
                @elseif($transaction_status == 'pending')
                    <span class="circle-box">
                        <img src="{{ url('/assets/img/pending.png') }}" style="width: 100px; position: absolute; top: -10px; left: -50px;">
                    </span>
                @else
                    <span class="circle-box">
                        <img src="{{ url('/assets/img/failed.png') }}" style="width: 100px; position: absolute; top: -10px; left: -50px;">
                    </span>
                @endif
            </div>
            <div class="icon-2 ani5">
                @if ($transaction_status == 'settlement' || $transaction_status == 'capture')
                    <span class="circle-box md bg-circle"></span>
                @elseif($transaction_status == 'pending')
                    <span class="circle-box md" style="background-color: orange;"></span>
                @else
                    <span class="circle-box md bg-critical"></span>
                @endif
            </div>
            <div class="icon-3 ani8">
                @if ($transaction_status == 'settlement' || $transaction_status == 'capture')
                    <span class="circle-box md bg-circle"></span>
                @elseif($transaction_status == 'pending')
                    <span class="circle-box md" style="background-color: orange;"></span>
                @else
                    <span class="circle-box md bg-critical"></span>
                @endif
            </div>
            <div class="icon-4 ani2">
                @if ($transaction_status == 'settlement' || $transaction_status == 'capture')
                    <span class="circle-box sm bg-circle"></span>
                @elseif($transaction_status == 'pending')
                    <span class="circle-box sm" style="background-color: orange;"></span>
                @else
                    <span class="circle-box sm bg-critical"></span>
                @endif
            </div>
            
            <div class="content">
                <div class="top">
                    <h2>{{ $status }}</h2>
                    @if ($transaction_status == 'pending')
                        <p>Menunggu Pembayaran Dari Anda</p>
                    @else
                        <p>Pembayaran Anda Telah {{ $status }}</p>
                    @endif
                </div>
                <div class="tf-spacing-16"></div>
                <div class="inner">
                    <p class="secondary_color fw_6">Total Transaksi</p>
                    <h1>Rp {{ number_format($transaction->total_amount) }}</h1>
                </div>
            </div>
            <a href="{{ $url }}" class="tf-btn accent large">Done</a>
            
        </div>

        <span class="line-through through-1"></span>
        <span class="line-through through-2"></span>
        <span class="line-through through-3"></span>
        <span class="line-through through-4"></span>
        <span class="line-through through-5"></span>
        <span class="line-through through-6"></span>
    </div>


    <script type="text/javascript" src="{{ url('/myhr/javascript/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('/myhr/javascript/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('/myhr/javascript/swiper-bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('/myhr/javascript/swiper.js') }}"></script>
    <script type="text/javascript" src="{{ url('/myhr/javascript/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{ url('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ url('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ url('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ url('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ url('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ url('adminlte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ url('adminlte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ url('adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ url('accounting.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ url('adminlte/plugins/chart.js/Chart.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
</body>

</html>