<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>
    <link rel="shorcut icon" href="{{ url('assets/img/kos.png') }}">
    <link rel="stylesheet" href="{{ url('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback') }}">
    <link rel="stylesheet" href="{{ url('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ url('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ url('adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ url('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('adminlte/plugins/jqvmap/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ url('adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ url('adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ url('adminlte/plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ url('adminlte/plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ url('https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ url('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css" integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js" integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ==" crossorigin=""></script>

    <style>
        .select2-container .select2-selection--multiple {
            min-height: 37px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            font-size: 10px;
            line-height: 17px;
            margin-top: 8px;
        }

        .select2-container .select2-selection--single {
            height: 37px;
            line-height: 37px;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            line-height: 37px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 37px;
        }

        .select2-results__option {
            line-height: 37px;
        }

        .select2-selection__choice {
            line-height: 37px;
            background-color: #cbe0ff !important;
            border-color: #0a58ca !important;
            color: #0a58ca !important;
            font-weight: bold;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #0a58ca !important;
            border-color: #0a58ca !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
            color: red !important;
            background-color: #cbe0ff !important;
        }
    </style>

    @stack('style')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

    <div class="preloader flex-column justify-content-center align-items-center">
        <img src="{{ url('assets/img/kos.png') }}" alt="Smart Kost" height="60" width="60">
    </div>

    @include('partials.topbar')

    @include('partials.sidebar')


    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <h1 class="mb-4" style="text-align: center;">{{ $title }}</h1>
            </div>
        </div>

        <section class="content">
            @yield('isi')
        </section>

    </div>

    @include('partials.footer')

    <aside class="control-sidebar control-sidebar-dark">
    </aside>
    </div>

    @include('partials.script')
    @stack('script')
    @include('sweetalert::alert')
</body>
</html>
