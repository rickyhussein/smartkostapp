
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>
    <link rel="shortcut icon" href="{{ url('assets/img/kos.png') }}" />
    <link rel="apple-touch-icon-precomposed" href="{{ url('assets/img/kos.png') }}" />
    <link rel="stylesheet" href="{{ url('/myhr/fonts/fonts.css') }}" />
    <link rel="stylesheet" href="{{ url('/myhr/fonts/icons-alipay.css') }}">
    <link rel="stylesheet" href="{{ url('/myhr/styles/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ url('/myhr/styles/swiper-bundle.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/myhr/styles/styles.css') }}" />
    <link rel="manifest" href="{{ url('/manifest.json') }}" data-pwa-version="set_in_manifest_and_pwa_js">
    <link rel="apple-touch-icon" sizes="192x192" href="{{ url('assets/img/kos.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="{{ url('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ url('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('clock/dist/bootstrap-clockpicker.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css" integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js" integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ==" crossorigin=""></script>

    <style>
        .select2-container .select2-selection--single {
            height: 45px;
            line-height: 45px;
            border-radius: 8px;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            line-height: 45px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 45px;
        }

        .select2-results__option {
            line-height: 45px;
        }

        .select2-selection__choice {
            line-height: 45px;
        }

        input[type="text"], input[type="number"], input[type="datetime"], input[type="file"], input[type="email"], select, textarea {
            border: 1px solid #acacac;
        }

        .readonly-checkbox {
            pointer-events: none !important;
            opacity: 1 !important;
        }

        .carousel-media {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }
    </style>
    @stack('style')
</head>

<body>
     <div class="preload preload-container">
        <div class="preload-logo"></div>
    </div>

    @if (Request::is('dashboard*'))
        <div class="app-header">
            <div class="tf-container">
                <div class="tf-topbar d-flex justify-content-between align-items-center">
                    <a class="user-info d-flex justify-content-between align-items-center" href="{{ url('/profile/owner') }}">
                        @if(auth()->user()->profile_photo )
                            <img src="{{ url('/storage/'.auth()->user()->profile_photo) }}" alt="image">
                        @else
                            <img src="{{ url('assets/img/foto_default.jpg') }}" alt="image">
                        @endif

                        <div class="content">
                            <h4 class="white_color">{{ auth()->user()->name }}</h4>
                            <p class="white_color fw_4">{{ auth()->user()->email }}</p>
                        </div>
                    </a>
                    <div class="d-flex align-items-center gap-4">
                        <a href="javascript:void(0);" id="btn-popup-left">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                                <path d="M7.25687 5.89462C8.06884 5.35208 9.02346 5.0625 10 5.0625C11.3095 5.0625 12.5654 5.5827 13.4913 6.50866C14.4173 7.43462 14.9375 8.6905 14.9375 10C14.9375 10.9765 14.6479 11.9312 14.1054 12.7431C13.5628 13.5551 12.7917 14.188 11.8895 14.5617C10.9873 14.9354 9.99452 15.0331 9.03674 14.8426C8.07896 14.6521 7.19918 14.1819 6.50866 13.4913C5.81814 12.8008 5.34789 11.921 5.15737 10.9633C4.96686 10.0055 5.06464 9.01271 5.43835 8.1105C5.81205 7.20829 6.44491 6.43716 7.25687 5.89462ZM8.29857 12.5464C8.80219 12.8829 9.3943 13.0625 10 13.0625C10.8122 13.0625 11.5912 12.7398 12.1655 12.1655C12.7398 11.5912 13.0625 10.8122 13.0625 10C13.0625 9.3943 12.8829 8.80219 12.5464 8.29857C12.2099 7.79494 11.7316 7.40241 11.172 7.17062C10.6124 6.93883 9.99661 6.87818 9.40254 6.99635C8.80847 7.11451 8.26279 7.40619 7.83449 7.83449C7.40619 8.26279 7.11451 8.80847 6.99635 9.40254C6.87818 9.99661 6.93883 10.6124 7.17062 11.172C7.40241 11.7316 7.79494 12.2099 8.29857 12.5464ZM24.7431 14.1054C23.9312 14.6479 22.9765 14.9375 22 14.9375C20.6905 14.9375 19.4346 14.4173 18.5087 13.4913C17.5827 12.5654 17.0625 11.3095 17.0625 10C17.0625 9.02346 17.3521 8.06884 17.8946 7.25687C18.4372 6.44491 19.2083 5.81205 20.1105 5.43835C21.0127 5.06464 22.0055 4.96686 22.9633 5.15737C23.921 5.34789 24.8008 5.81814 25.4913 6.50866C26.1819 7.19918 26.6521 8.07896 26.8426 9.03674C27.0331 9.99452 26.9354 10.9873 26.5617 11.8895C26.1879 12.7917 25.5551 13.5628 24.7431 14.1054ZM23.7014 7.45363C23.1978 7.11712 22.6057 6.9375 22 6.9375C21.1878 6.9375 20.4088 7.26016 19.8345 7.83449C19.2602 8.40882 18.9375 9.18778 18.9375 10C18.9375 10.6057 19.1171 11.1978 19.4536 11.7014C19.7901 12.2051 20.2684 12.5976 20.828 12.8294C21.3876 13.0612 22.0034 13.1218 22.5975 13.0037C23.1915 12.8855 23.7372 12.5938 24.1655 12.1655C24.5938 11.7372 24.8855 11.1915 25.0037 10.5975C25.1218 10.0034 25.0612 9.38763 24.8294 8.82803C24.5976 8.26844 24.2051 7.79014 23.7014 7.45363ZM7.25687 17.8946C8.06884 17.3521 9.02346 17.0625 10 17.0625C11.3095 17.0625 12.5654 17.5827 13.4913 18.5087C14.4173 19.4346 14.9375 20.6905 14.9375 22C14.9375 22.9765 14.6479 23.9312 14.1054 24.7431C13.5628 25.5551 12.7917 26.1879 11.8895 26.5617C10.9873 26.9354 9.99452 27.0331 9.03674 26.8426C8.07896 26.6521 7.19918 26.1819 6.50866 25.4913C5.81814 24.8008 5.34789 23.921 5.15737 22.9633C4.96686 22.0055 5.06464 21.0127 5.43835 20.1105C5.81205 19.2083 6.44491 18.4372 7.25687 17.8946ZM8.29857 24.5464C8.80219 24.8829 9.3943 25.0625 10 25.0625C10.8122 25.0625 11.5912 24.7398 12.1655 24.1655C12.7398 23.5912 13.0625 22.8122 13.0625 22C13.0625 21.3943 12.8829 20.8022 12.5464 20.2986C12.2099 19.7949 11.7316 19.4024 11.172 19.1706C10.6124 18.9388 9.99661 18.8782 9.40254 18.9963C8.80847 19.1145 8.26279 19.4062 7.83449 19.8345C7.40619 20.2628 7.11451 20.8085 6.99635 21.4025C6.87818 21.9966 6.93883 22.6124 7.17062 23.172C7.40241 23.7316 7.79494 24.2099 8.29857 24.5464ZM19.2569 17.8946C20.0688 17.3521 21.0235 17.0625 22 17.0625C23.3095 17.0625 24.5654 17.5827 25.4913 18.5087C26.4173 19.4346 26.9375 20.6905 26.9375 22C26.9375 22.9765 26.6479 23.9312 26.1054 24.7431C25.5628 25.5551 24.7917 26.1879 23.8895 26.5617C22.9873 26.9354 21.9945 27.0331 21.0367 26.8426C20.079 26.6521 19.1992 26.1819 18.5087 25.4913C17.8181 24.8008 17.3479 23.921 17.1574 22.9633C16.9669 22.0055 17.0646 21.0127 17.4383 20.1105C17.8121 19.2083 18.4449 18.4372 19.2569 17.8946ZM20.2986 24.5464C20.8022 24.8829 21.3943 25.0625 22 25.0625C22.8122 25.0625 23.5912 24.7398 24.1655 24.1655C24.7398 23.5912 25.0625 22.8122 25.0625 22C25.0625 21.3943 24.8829 20.8022 24.5464 20.2986C24.2099 19.7949 23.7316 19.4024 23.172 19.1706C22.6124 18.9388 21.9966 18.8782 21.4025 18.9963C20.8085 19.1145 20.2628 19.4062 19.8345 19.8345C19.4062 20.2628 19.1145 20.8085 18.9963 21.4025C18.8782 21.9966 18.9388 22.6124 19.1706 23.172C19.4024 23.7316 19.7949 24.2099 20.2986 24.5464Z" fill="white" stroke="white" stroke-width="0.125"/>
                            </svg>
                        </a>

                        @can('notifications_owner')
                            <a href="{{ url('/notifications/owner') }}" class="icon-notification1">
                                @if (auth()->user()->notifications()->whereNull('read_at')->count() > 0)
                                    <span>{{ auth()->user()->notifications()->whereNull('read_at')->count() }}</span>
                                @endif
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="header is-fixed">
            <div class="tf-container">
                <div class="tf-statusbar d-flex justify-content-between align-items-center position-relative" style="height: 50px;">

                    <div class="flex-item start" style="width: 50px; margin-top: -50px">
                        @yield('back')
                    </div>

                    <div class="flex-item center text-center flex-grow-1">
                        <h3 class="m-0">{{ $title }}</h3>
                    </div>

                    <div class="flex-item end text-end" style="width: 50px;">
                        <a href="javascript:void(0);" id="btn-popup-left" class="d-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                                <path d="M7.25687 5.89462C8.06884 5.35208 9.02346 5.0625 10 5.0625C11.3095 5.0625 12.5654 5.5827 13.4913 6.50866C14.4173 7.43462 14.9375 8.6905 14.9375 10C14.9375 10.9765 14.6479 11.9312 14.1054 12.7431C13.5628 13.5551 12.7917 14.188 11.8895 14.5617C10.9873 14.9354 9.99452 15.0331 9.03674 14.8426C8.07896 14.6521 7.19918 14.1819 6.50866 13.4913C5.81814 12.8008 5.34789 11.921 5.15737 10.9633C4.96686 10.0055 5.06464 9.01271 5.43835 8.1105C5.81205 7.20829 6.44491 6.43716 7.25687 5.89462ZM8.29857 12.5464C8.80219 12.8829 9.3943 13.0625 10 13.0625C10.8122 13.0625 11.5912 12.7398 12.1655 12.1655C12.7398 11.5912 13.0625 10.8122 13.0625 10C13.0625 9.3943 12.8829 8.80219 12.5464 8.29857C12.2099 7.79494 11.7316 7.40241 11.172 7.17062C10.6124 6.93883 9.99661 6.87818 9.40254 6.99635C8.80847 7.11451 8.26279 7.40619 7.83449 7.83449C7.40619 8.26279 7.11451 8.80847 6.99635 9.40254C6.87818 9.99661 6.93883 10.6124 7.17062 11.172C7.40241 11.7316 7.79494 12.2099 8.29857 12.5464ZM24.7431 14.1054C23.9312 14.6479 22.9765 14.9375 22 14.9375C20.6905 14.9375 19.4346 14.4173 18.5087 13.4913C17.5827 12.5654 17.0625 11.3095 17.0625 10C17.0625 9.02346 17.3521 8.06884 17.8946 7.25687C18.4372 6.44491 19.2083 5.81205 20.1105 5.43835C21.0127 5.06464 22.0055 4.96686 22.9633 5.15737C23.921 5.34789 24.8008 5.81814 25.4913 6.50866C26.1819 7.19918 26.6521 8.07896 26.8426 9.03674C27.0331 9.99452 26.9354 10.9873 26.5617 11.8895C26.1879 12.7917 25.5551 13.5628 24.7431 14.1054ZM23.7014 7.45363C23.1978 7.11712 22.6057 6.9375 22 6.9375C21.1878 6.9375 20.4088 7.26016 19.8345 7.83449C19.2602 8.40882 18.9375 9.18778 18.9375 10C18.9375 10.6057 19.1171 11.1978 19.4536 11.7014C19.7901 12.2051 20.2684 12.5976 20.828 12.8294C21.3876 13.0612 22.0034 13.1218 22.5975 13.0037C23.1915 12.8855 23.7372 12.5938 24.1655 12.1655C24.5938 11.7372 24.8855 11.1915 25.0037 10.5975C25.1218 10.0034 25.0612 9.38763 24.8294 8.82803C24.5976 8.26844 24.2051 7.79014 23.7014 7.45363ZM7.25687 17.8946C8.06884 17.3521 9.02346 17.0625 10 17.0625C11.3095 17.0625 12.5654 17.5827 13.4913 18.5087C14.4173 19.4346 14.9375 20.6905 14.9375 22C14.9375 22.9765 14.6479 23.9312 14.1054 24.7431C13.5628 25.5551 12.7917 26.1879 11.8895 26.5617C10.9873 26.9354 9.99452 27.0331 9.03674 26.8426C8.07896 26.6521 7.19918 26.1819 6.50866 25.4913C5.81814 24.8008 5.34789 23.921 5.15737 22.9633C4.96686 22.0055 5.06464 21.0127 5.43835 20.1105C5.81205 19.2083 6.44491 18.4372 7.25687 17.8946ZM8.29857 24.5464C8.80219 24.8829 9.3943 25.0625 10 25.0625C10.8122 25.0625 11.5912 24.7398 12.1655 24.1655C12.7398 23.5912 13.0625 22.8122 13.0625 22C13.0625 21.3943 12.8829 20.8022 12.5464 20.2986C12.2099 19.7949 11.7316 19.4024 11.172 19.1706C10.6124 18.9388 9.99661 18.8782 9.40254 18.9963C8.80847 19.1145 8.26279 19.4062 7.83449 19.8345C7.40619 20.2628 7.11451 20.8085 6.99635 21.4025C6.87818 21.9966 6.93883 22.6124 7.17062 23.172C7.40241 23.7316 7.79494 24.2099 8.29857 24.5464ZM19.2569 17.8946C20.0688 17.3521 21.0235 17.0625 22 17.0625C23.3095 17.0625 24.5654 17.5827 25.4913 18.5087C26.4173 19.4346 26.9375 20.6905 26.9375 22C26.9375 22.9765 26.6479 23.9312 26.1054 24.7431C25.5628 25.5551 24.7917 26.1879 23.8895 26.5617C22.9873 26.9354 21.9945 27.0331 21.0367 26.8426C20.079 26.6521 19.1992 26.1819 18.5087 25.4913C17.8181 24.8008 17.3479 23.921 17.1574 22.9633C16.9669 22.0055 17.0646 21.0127 17.4383 20.1105C17.8121 19.2083 18.4449 18.4372 19.2569 17.8946ZM20.2986 24.5464C20.8022 24.8829 21.3943 25.0625 22 25.0625C22.8122 25.0625 23.5912 24.7398 24.1655 24.1655C24.7398 23.5912 25.0625 22.8122 25.0625 22C25.0625 21.3943 24.8829 20.8022 24.5464 20.2986C24.2099 19.7949 23.7316 19.4024 23.172 19.1706C22.6124 18.9388 21.9966 18.8782 21.4025 18.9963C20.8085 19.1145 20.2628 19.4062 19.8345 19.8345C19.4062 20.2628 19.1145 20.8085 18.9963 21.4025C18.8782 21.9966 18.9388 22.6124 19.1706 23.172C19.4024 23.7316 19.7949 24.2099 20.2986 24.5464Z" fill="black" stroke="black" stroke-width="0.125"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @yield('container')

    @if (auth()->user())
        <div class="bottom-navigation-bar">
            <div class="tf-container">
                <ul class="tf-navigation-bar">
                    <li class="{{ Request::is('dashboard/owner*') ? 'active' : '' }} mt-1">
                        <a class="fw_6 d-flex justify-content-center align-items-center flex-column" href="{{ url('/dashboard/owner') }}">
                            <svg fill="#{{ Request::is('dashboard/owner*') ? '0000FF' : '000000' }}" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                style="width: 25px" viewBox="0 0 495.398 495.398"
                                xml:space="preserve">
                            <g>
                                <g>
                                    <g>
                                        <path d="M487.083,225.514l-75.08-75.08V63.704c0-15.682-12.708-28.391-28.413-28.391c-15.669,0-28.377,12.709-28.377,28.391
                                            v29.941L299.31,37.74c-27.639-27.624-75.694-27.575-103.27,0.05L8.312,225.514c-11.082,11.104-11.082,29.071,0,40.158
                                            c11.087,11.101,29.089,11.101,40.172,0l187.71-187.729c6.115-6.083,16.893-6.083,22.976-0.018l187.742,187.747
                                            c5.567,5.551,12.825,8.312,20.081,8.312c7.271,0,14.541-2.764,20.091-8.312C498.17,254.586,498.17,236.619,487.083,225.514z"/>
                                        <path d="M257.561,131.836c-5.454-5.451-14.285-5.451-19.723,0L72.712,296.913c-2.607,2.606-4.085,6.164-4.085,9.877v120.401
                                            c0,28.253,22.908,51.16,51.16,51.16h81.754v-126.61h92.299v126.61h81.755c28.251,0,51.159-22.907,51.159-51.159V306.79
                                            c0-3.713-1.465-7.271-4.085-9.877L257.561,131.836z"/>
                                    </g>
                                </g>
                            </g>
                            </svg>
                            <span style="color:#{{ Request::is('dashboard/owner*') ? '0000FF' : '000000' }}">Home</span>
                        </a>
                    </li>

                    <li class="{{ Request::is('properties/owner*') ? 'active' : '' }}">
                        <a class="fw_4 d-flex justify-content-center align-items-center flex-column" href="{{ url('/properties/owner') }}">
                            <svg style="width: 28px;" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 122.88 115.52"><defs><style>.cls-1{fill-rule:evenodd;}</style></defs><title>property</title><path class="cls-1" fill="#{{ Request::is('properties/owner*') ? '0000FF' : '000000' }}" d="M119.2,111.86V3.66H57.86V41l-3.65-2.9V2.68A2.89,2.89,0,0,1,55.05.87h0A2.92,2.92,0,0,1,57.13,0h62.8A2.92,2.92,0,0,1,122,.86l.13.14a2.9,2.9,0,0,1,.74,1.94V31.15h0v80.71H104V87.1a1.67,1.67,0,0,0-1.67-1.67H90.44v30.09h32.44v-3.66ZM7.74,115.51V79.74a6.18,6.18,0,0,1-4.27.2A5.08,5.08,0,0,1,1.12,78.3,5.2,5.2,0,0,1,0,75.64a6.72,6.72,0,0,1,1.61-5h0a1.67,1.67,0,0,1,.23-.23l38.38-30a1.38,1.38,0,0,1,1.81-.07l38.47,29.9h0l.17.15a6.34,6.34,0,0,1,1.79,5.84,5.39,5.39,0,0,1-3.4,3.82,5.9,5.9,0,0,1-4.57-.3v35.59H70.77V78.18c0-.68-26.39-21.54-29.3-23.81-3.09,2.35-30,23-30,23.91v37.24ZM41.33,79.2A14.75,14.75,0,0,1,56,93.89v15.65H26.64V93.89A14.73,14.73,0,0,1,41.33,79.2Zm1.27,2.62V93.93H53.46v0A12.17,12.17,0,0,0,42.6,81.82Zm0,14.66V107H53.46V96.48ZM40.05,107V96.48H29.2V107Zm0-13.06V81.82A12.18,12.18,0,0,0,29.2,93.89v0ZM23.94,112.32H58.71v2.55H23.94v-2.55ZM66.68,12.87h9.85a.29.29,0,0,1,.28.28v11.4a.28.28,0,0,1-.28.27H66.68a.27.27,0,0,1-.28-.27V13.15a.28.28,0,0,1,.28-.28Zm33.86,0h9.85a.29.29,0,0,1,.28.28v11.4a.28.28,0,0,1-.28.27h-9.85a.28.28,0,0,1-.28-.27V13.15a.29.29,0,0,1,.28-.28Zm-16.93,0h9.85a.29.29,0,0,1,.28.28v11.4a.28.28,0,0,1-.28.27H83.61a.27.27,0,0,1-.28-.27V13.15a.28.28,0,0,1,.28-.28ZM66.68,35.76h9.85a.28.28,0,0,1,.28.27v11.4a.29.29,0,0,1-.28.28H66.68a.28.28,0,0,1-.28-.28V36a.27.27,0,0,1,.28-.27Zm33.86,0h9.85a.28.28,0,0,1,.28.27v11.4a.29.29,0,0,1-.28.28h-9.85a.29.29,0,0,1-.28-.28V36a.28.28,0,0,1,.28-.27Zm-16.93,0h9.85a.28.28,0,0,1,.28.27v11.4a.29.29,0,0,1-.28.28H83.61a.28.28,0,0,1-.28-.28V36a.27.27,0,0,1,.28-.27Zm16.93,22.88h9.85a.29.29,0,0,1,.28.28V70.31a.29.29,0,0,1-.28.28h-9.85a.29.29,0,0,1-.28-.28V58.92a.29.29,0,0,1,.28-.28Zm-16.93,0h9.85a.29.29,0,0,1,.28.28V70.31a.29.29,0,0,1-.28.28h-3V66.82l-7.11-5.64V58.92a.28.28,0,0,1,.28-.28Z"/></svg>
                            <span style="color:#{{ Request::is('properties/owner*') ? '0000FF' : '000000' }}" class="ms-2">Properti</span>
                        </a>
                    </li>

                    <li class="{{ Request::is('rents/owner*') ? 'active' : '' }}">
                        <a class="fw_4 d-flex justify-content-center align-items-center flex-column" href="{{ url('/rents/owner') }}">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="width: 28px;" viewBox="0 0 122.879 110.328" enable-background="new 0 0 122.879 110.328" xml:space="preserve">
                                <g fill="#{{ Request::is('rents/owner*') ? '0000FF' : '000000' }}">
                                    <path d="M11.098,5.322l5.111-4.927c0.55-0.529,1.419-0.524,1.964,0l5.178,4.994c0.289,0.277,0.434,0.649,0.434,1.021v4.77 l92.819,0.006l4.864,0.028c0.781,0.002,1.412,0.64,1.41,1.42c-0.001,0.218-0.052,0.425-0.142,0.609l-4.991,10.331 c-0.243,0.506-0.749,0.801-1.276,0.801l-22.511,0.001v3.383h-6.882v-3.383l-40.771,0.001v3.381h-6.882v-3.381H23.787l0.003,81.802 c0,1.136-0.47,2.173-1.219,2.924c-0.757,0.755-1.797,1.225-2.929,1.225h-4.904c-1.139,0-2.178-0.468-2.929-1.219l-0.089-0.097 c-0.698-0.743-1.13-1.742-1.13-2.833V24.379H4.148c-1.138,0-2.177-0.47-2.928-1.221C0.47,22.408,0,21.369,0,20.231v-4.904 c0-1.139,0.467-2.178,1.219-2.93c0.75-0.75,1.787-1.218,2.929-1.218h6.442V6.41C10.59,5.973,10.788,5.583,11.098,5.322 L11.098,5.322z M54.915,47.739l-0.076,2.939h1.724l2.94-0.076l0.279,0.354l-0.305,3.701l-3.269-0.076h-1.47v0.329l0.202,5.323 h-5.094l0.253-4.814l-0.253-11.583h10.948l0.279,0.354l-0.329,3.701l-4.055-0.152H54.915L54.915,47.739z M69.795,43.532 c2.383,0,4.224,0.706,5.525,2.116c1.301,1.411,1.951,3.401,1.951,5.968c0,2.839-0.715,5.035-2.142,6.59 c-1.428,1.554-3.451,2.331-6.07,2.331c-2.381,0-4.223-0.713-5.523-2.141c-1.301-1.429-1.952-3.451-1.952-6.07 c0-2.805,0.714-4.972,2.142-6.5C65.154,44.297,67.177,43.532,69.795,43.532L69.795,43.532z M69.34,47.587 c-0.659,0-1.158,0.114-1.496,0.342c-0.338,0.229-0.578,0.63-0.723,1.204c-0.143,0.575-0.214,1.411-0.214,2.509 c0,1.403,0.075,2.467,0.228,3.193c0.152,0.727,0.409,1.233,0.773,1.521c0.362,0.287,0.898,0.431,1.608,0.431 c0.659,0,1.157-0.114,1.495-0.343s0.579-0.633,0.722-1.216c0.145-0.583,0.216-1.424,0.216-2.522c0-1.385-0.076-2.441-0.229-3.167 c-0.151-0.727-0.409-1.234-0.772-1.521C70.585,47.731,70.049,47.587,69.34,47.587L69.34,47.587z M90.378,53.771 c1.217,1.893,2.433,3.649,3.65,5.271l-0.076,0.559c-1.724,0.523-3.422,0.835-5.095,0.937l-0.48-0.405l-0.305-0.634 c-0.135-0.271-0.406-0.84-0.811-1.71c-0.406-0.87-0.761-1.686-1.065-2.446h-1.698l0.179,4.891h-5.095l0.254-4.814l-0.254-11.583 l7.78-0.025c1.842,0,3.261,0.434,4.257,1.305c0.998,0.87,1.496,2.125,1.496,3.764c0,0.962-0.24,1.866-0.723,2.711 C91.911,52.437,91.24,53.163,90.378,53.771L90.378,53.771z M87.768,49.387c0-0.675-0.173-1.179-0.52-1.507 c-0.346-0.33-0.907-0.512-1.685-0.545L84.65,47.41l-0.101,4.232l1.849,0.102c0.474-0.221,0.82-0.516,1.04-0.887 C87.658,50.484,87.768,49.994,87.768,49.387L87.768,49.387z M52.64,77.692c1.217,1.893,2.433,3.648,3.65,5.271l-0.076,0.559 c-1.724,0.523-3.422,0.835-5.095,0.938l-0.48-0.406l-0.305-0.634c-0.135-0.271-0.406-0.84-0.811-1.71 c-0.406-0.87-0.76-1.686-1.065-2.445H46.76l0.178,4.891h-5.094l0.254-4.814l-0.254-11.583l7.78-0.024 c1.843,0,3.261,0.435,4.258,1.305c0.998,0.87,1.496,2.125,1.496,3.764c0,0.963-0.24,1.866-0.723,2.712 C54.173,76.357,53.502,77.083,52.64,77.692L52.64,77.692z M50.03,73.308c0-0.676-0.173-1.179-0.52-1.508 c-0.346-0.33-0.907-0.511-1.685-0.544l-0.913,0.075l-0.101,4.232l1.849,0.102c0.473-0.221,0.82-0.516,1.039-0.888 C49.92,74.405,50.03,73.915,50.03,73.308L50.03,73.308z M69.712,80.1l0.279,0.354l-0.305,3.7H58.13l0.254-4.814L58.13,67.757 h11.759l0.279,0.354l-0.329,3.701L65.81,71.66h-2.611l-0.05,2.307h2.509l2.636-0.076l0.278,0.354l-0.305,3.7l-2.939-0.075h-2.281 l-0.024,0.962l0.051,1.419h2.433L69.712,80.1L69.712,80.1z M86.81,78.807l0.202,5.348h-5.524l-4.612-8.77H76.57l-0.025,2.84 l0.203,5.93h-4.612l0.253-4.814l-0.253-11.583h5.524l4.612,8.77h0.304l-0.151-8.591l4.663-0.279L86.81,78.807L86.81,78.807z M101.904,68.111l-0.278,3.701l-3.347-0.152h-0.304l-0.126,7.172l0.202,5.322h-5.068l0.254-4.814l-0.127-7.68h-0.33l-3.37,0.152 l-0.304-0.354l0.278-3.701h12.241L101.904,68.111L101.904,68.111z M37.906,31.007h66.599c2.104,0,4.02,0.866,5.406,2.251 c1.396,1.397,2.26,3.313,2.26,5.415v50.646c0,2.098-0.865,4.012-2.255,5.404l-0.01,0.011c-1.394,1.388-3.306,2.252-5.401,2.252 H37.906c-2.101,0-4.017-0.864-5.408-2.253c-1.393-1.395-2.258-3.311-2.258-5.414V38.673c0-2.109,0.862-4.027,2.25-5.416 S35.797,31.007,37.906,31.007L37.906,31.007z M104.505,34.797H37.906c-1.065,0-2.036,0.437-2.738,1.139 c-0.701,0.701-1.139,1.672-1.139,2.737v50.646c0,1.064,0.438,2.037,1.137,2.739c0.704,0.7,1.677,1.138,2.74,1.138h66.599 c1.065,0,2.034-0.437,2.733-1.137c0.706-0.706,1.143-1.675,1.143-2.74V38.673c0-1.063-0.437-2.036-1.138-2.74 C106.541,35.234,105.569,34.797,104.505,34.797L104.505,34.797z"/>
                                </g>
                            </svg>
                            <span style="color:#{{ Request::is('rents/owner*') ? '0000FF' : '000000' }}" class="ms-2">Pengajuan</span>
                        </a>
                    </li>

                    <li class="{{ Request::is('keuangan/owner*') ? 'active' : '' }}">
                        <a class="fw_4 d-flex justify-content-center align-items-center flex-column" href="{{ url('/laporan-keuangan/owner') }}">
                            <svg style="width: 22px;" fill="#{{ Request::is('keuangan/owner*') ? '0000FF' : '000000' }}" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                viewBox="0 0 184.153 184.153" xml:space="preserve">
                            <g>
                                <g>
                                    <g>
                                        <path d="M129.318,0H26.06c-1.919,0-3.475,1.554-3.475,3.475v177.203c0,1.92,1.556,3.475,3.475,3.475h132.034
                                            c1.919,0,3.475-1.554,3.475-3.475V34.131C161.568,22.011,140.771,0,129.318,0z M154.62,177.203H29.535V6.949h99.784
                                            c7.803,0,25.301,18.798,25.301,27.182V177.203z"/>
                                        <path d="M71.23,76.441c15.327,0,27.797-12.47,27.797-27.797c0-15.327-12.47-27.797-27.797-27.797
                                            c-15.327,0-27.797,12.47-27.797,27.797C43.433,63.971,55.902,76.441,71.23,76.441z M71.229,27.797
                                            c11.497,0,20.848,9.351,20.848,20.847c0,0.888-0.074,1.758-0.183,2.617l-18.071-2.708L62.505,29.735
                                            C65.162,28.503,68.112,27.797,71.229,27.797z M56.761,33.668l11.951,19.869c0.534,0.889,1.437,1.49,2.462,1.646l18.669,2.799
                                            c-3.433,6.814-10.477,11.51-18.613,11.51c-11.496,0-20.847-9.351-20.847-20.847C50.381,42.767,52.836,37.461,56.761,33.668z"/>
                                        <rect x="46.907" y="90.339" width="73.058" height="6.949"/>
                                        <rect x="46.907" y="107.712" width="48.644" height="6.949"/>
                                        <rect x="46.907" y="125.085" width="62.542" height="6.949"/>
                                    </g>
                                </g>
                            </g>
                            </svg>
                            Keuangan
                        </a>
                    </li>

                    <li class="{{ Request::is('profile/owner*') ? 'active' : '' }}"><a class="fw_4 d-flex justify-content-center align-items-center flex-column" href="{{ url('/profile/owner') }}"><i class="icon-user-outline"></i> Profile</a> </li>
                </ul>
            </div>
        </div>
    @endif


    <div class="tf-panel left">
        <div class="panel_overlay"></div>
        <div class="panel-box panel-left panel-sidebar">
            <div class="header-sidebar bg_white_color is-fixed">
                <div class="tf-container">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ url('/dashboard/owner') }}" class="sidebar-logo">
                            <img src="{{ url('assets/img/kos.png') }}"  alt="logo">
                            <span style="color: white; font-size:20px" class="ms-2">SMART KOS</span>
                        </a>
                        <a href="javascript:void(0);" class="clear-panel"> <i class="icon-close1"></i> </a>
                    </div>
                </div>
            </div>

            <div class="panel-body">
                <div class="tf-container">
                    <div class="box-content">

                        <ul class="box-nav">
                            <li>
                                <a href="{{ url('/dashboard/owner') }}" class="nav-link" >
                                    <span style="{{ Request::is('dashboard/owner*') ? 'color: blue' : '' }}">Home</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/logout') }}" class="nav-link" onclick="return confirm('Are You Sure?')">
                                    <span style="{{ Request::is('logout*') ? 'color: blue' : '' }}">Log Out</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
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
    <script type="text/javascript" src="{{ url('/clock/dist/bootstrap-clockpicker.min.js') }}"></script>
    <script src="{{ url('accounting.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ url('adminlte/plugins/chart.js/Chart.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <script>
        config = {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
        }

        flatpickr("input[type=datetime-local]", config)
        flatpickr("input[type=datetime]", {})

        $(function () {
            $('form').on('submit', function() {
                if ($(this).attr('method').toUpperCase() !== 'GET') {
                    $(':input[type="submit"]').prop('disabled', true);
                }
            });

            $('form').on('keypress', function(event) {
                if (event.which === 13 && $(this).attr('method').toUpperCase() !== 'GET' && !$(event.target).is('textarea') && !$(event.target).is('trix-editor')) {
                    event.preventDefault();
                }
            });

            $('#tablePayroll').DataTable( {
                "responsive": true,
                "paging": false,
                "info": false,
                "scrollCollapse": true,
                "autoWidth": false,
                'searching': false
            });
             $("#tableprint").DataTable({
                "responsive": true, "autoWidth": false,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                dom: 'flrtip'
            }).buttons().container().appendTo('#tableprint_wrapper .col-md-6:eq(0)');
        });

    </script>
    @include('sweetalert::alert')
    @stack('script')


</body>

</html>
