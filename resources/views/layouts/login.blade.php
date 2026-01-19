
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover">
    <title>{{ $title }}</title>
    <link rel="shortcut icon" href="{{ url('assets/img/kos.png') }}" />
    <link rel="apple-touch-icon-precomposed" href="{{ url('assets/img/kos.png') }}" />
    <link rel="stylesheet" href="{{ url('/myhr/fonts/fonts.css') }}" />
    <link rel="stylesheet" href="{{ url('/myhr/fonts/icons-alipay.css') }}">
    <link rel="stylesheet" href="{{ url('/myhr/styles/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ url('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ url('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="{{ url('/myhr/styles/styles.css') }}" />
    <link rel="manifest" href="{{ url('/myhr/_manifest.json') }}" data-pwa-version="set_in_manifest_and_pwa_js">
    <link rel="apple-touch-icon" sizes="192x192" href="{{ url('/myhr/app/icons/icon-192x192.png') }}">
    @stack('style')
</head>

<body>
    <div class="preload preload-container">
       <div class="preload-logo">
         <div class="spinner"></div>
       </div>
    </div>

    @yield('back')


    <div class="mt-7 login-section">
        <div class="tf-container">
            @yield('container')
        </div>
    </div>

    <script type="text/javascript" src="{{  url('/myhr/javascript/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{  url('/myhr/javascript/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{  url('/myhr/javascript/password-addon.js') }}"></script>
    <script type="text/javascript" src="{{  url('/myhr/javascript/main.js') }}"></script>
    <script src="{{ url('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ url('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('adminlte/dist/js/adminlte.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>


    <script>
        $(function(){
          $('form').on('submit', function(){
            $(':input[type="submit"]').prop('disabled', true);
          })
          if ('serviceWorker' in navigator) {
              window.addEventListener('load', function () {
                  navigator.serviceWorker.register('/service-worker.js')
                      .then(reg => console.log('SW registered', reg))
                      .catch(err => console.log('SW failed', err));
              });
          }
        })
    </script>
    @stack('script')
    @include('sweetalert::alert')

</body>

</html>
