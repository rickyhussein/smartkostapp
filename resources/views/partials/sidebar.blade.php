<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ url('/dashboard') }}" class="brand-link">
        <img src="{{ url('assets/img/kos.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Smart Kost</span>
    </a>
    <div class="sidebar">
        <nav class="mt-3">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item {{ Request::is('profile*') || Request::is('notifications') || Request::is('password/edit') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::is('profile') ? 'active' : '' }}">
                        @if(auth()->user()->profile_photo)
                            <img src="{{ url('storage/'.auth()->user()->profile_photo) }}" class="mr-1" style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover;">
                        @else
                            <img src="{{ url('assets/img/foto_default.jpg') }}" class="mr-1" style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover;">
                        @endif
                        <p>
                            {{ auth()->user()->name }}
                            @php
                                $notifications = auth()->user()->notifications()->whereNull('read_at')->count();
                            @endphp
                            @if ($notifications > 0)
                                <span class="badge badge-danger navbar-badge mt-1">{{ $notifications }}</span>
                            @endif
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('profile_admin')
                            <li class="nav-item">
                                <a href="{{ url('/profile') }}" class="nav-link {{ Request::is('profile') ? 'active' : '' }}">
                                    <i class="far fa-user nav-icon"></i>
                                    <p>Profile</p>
                                </a>
                            </li>
                        @endcan

                        @can('ganti_password_admin')
                            <li class="nav-item">
                                <a href="{{ url('/password/edit') }}" class="nav-link {{ Request::is('password/edit') ? 'active' : '' }}">
                                    <i class="fa fa-key nav-icon"></i>
                                    <p>Ganti Password</p>
                                </a>
                            </li>
                        @endcan

                        @can('notifications_admin')
                            <li class="nav-item">
                                <a href="{{ url('/notifications') }}" class="nav-link {{ Request::is('notifications') ? 'active' : '' }}">
                                    <i class="fas fa-bell nav-icon"></i>
                                    <p>Notifications</p>
                                    @if ($notifications > 0)
                                        <span class="badge badge-danger navbar-badge">{{ $notifications }}</span>
                                    @endif
                                </a>
                            </li>
                        @endcan

                        @can('dashboard_owner')
                            <li class="nav-item">
                                <a href="{{ url('/dashboard/owner') }}" class="nav-link {{ Request::is('dashboard/owner') ? 'active' : '' }}">
                                    <i class="fas fa-user-secret nav-icon"></i>
                                    <p>Dashboard Owner</p>
                                </a>
                            </li>
                        @endcan

                        @can('dashboard_user')
                            <li class="nav-item">
                                <a href="{{ url('/dashboard/user') }}" class="nav-link {{ Request::is('dashboard/user') ? 'active' : '' }}">
                                    <i class="fas fa-user-md nav-icon"></i>
                                    <p>Dashboard User</p>
                                </a>
                            </li>
                        @endcan

                        <li class="nav-item">
                            <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>
                                    Log Out
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>

                @can('dashboard_admin')
                    <hr style="border-top: 1px solid dimgray; margin: 10px 0;">
                    <li class="nav-item">
                        <a href="{{ url('/dashboard') }}" class="nav-link {{ Request::is('dashboard*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                @endcan


                @if(auth()->user()->hasAnyPermission(['roles_admin', 'permissions_admin', 'users_admin', 'peraturan_admin', 'bank_admin', 'fasilitas_admin', 'provinsi_admin', 'kota_admin', 'kecamatan_admin', 'kelurahan_admin', 'berita_admin']))
                    <hr style="border-top: 1px solid dimgray; margin: 10px 0;">

                    @can('users_admin')
                        <li class="nav-item">
                            <a href="{{ url('/users') }}" class="nav-link {{ Request::is('users*') ? 'active' : '' }}">
                                <i class="nav-icon fa fa-solid fa-users"></i>
                                <p>
                                    Users
                                </p>
                            </a>
                        </li>
                    @endcan

                    @can('roles_admin')
                        <li class="nav-item">
                            <a href="{{ url('/roles') }}" class="nav-link {{ Request::is('roles*') ? 'active' : '' }}">
                                <i class="nav-icon fa fa-solid fa-hat-cowboy"></i>
                                <p>
                                    Roles
                                </p>
                            </a>
                        </li>
                    @endcan

                    @can('permissions_admin')
                        <li class="nav-item">
                            <a href="{{ url('/permissions') }}" class="nav-link {{ Request::is('permissions*') ? 'active' : '' }}">
                                <i class="nav-icon fa fa-solid fa-tools text-lg"></i>
                                <p>
                                    Permissions
                                </p>
                            </a>
                        </li>
                    @endcan

                    @can('properti_admin')
                        <li class="nav-item">
                            <a href="{{ url('/properties') }}" class="nav-link {{ Request::is('properties*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-home"></i>
                                <p>
                                    Properti
                                </p>
                            </a>
                        </li>
                    @endcan

                    @can('peraturan_admin')
                        <li class="nav-item">
                            <a href="{{ url('/regulations') }}" class="nav-link {{ Request::is('regulations*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-virus-slash"></i>
                                <p>
                                    Peraturan
                                </p>
                            </a>
                        </li>
                    @endcan

                    @can('bank_admin')
                        <li class="nav-item">
                            <a href="{{ url('/banks') }}" class="nav-link {{ Request::is('banks*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-wallet"></i>
                                <p>
                                    Bank
                                </p>
                            </a>
                        </li>
                    @endcan

                    @can('fasilitas_admin')
                        <li class="nav-item">
                            <a href="{{ url('/facilities') }}" class="nav-link {{ Request::is('facilities*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-couch"></i>
                                <p>
                                    Fasilitas
                                </p>
                            </a>
                        </li>
                    @endcan

                    @can('provinsi_admin')
                        <li class="nav-item">
                            <a href="{{ url('/provinces') }}" class="nav-link {{ Request::is('provinces*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-map"></i>
                                <p>
                                    Provinsi
                                </p>
                            </a>
                        </li>
                    @endcan

                    @can('kota_admin')
                        <li class="nav-item">
                            <a href="{{ url('/cities') }}" class="nav-link {{ Request::is('cities*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-map-pin"></i>
                                <p>
                                    Kota / Kabupaten
                                </p>
                            </a>
                        </li>
                    @endcan

                    @can('kecamatan_admin')
                        <li class="nav-item">
                            <a href="{{ url('/districts') }}" class="nav-link {{ Request::is('districts*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-location-arrow"></i>
                                <p>
                                    Kecamatan
                                </p>
                            </a>
                        </li>
                    @endcan

                    @can('kelurahan_admin')
                        <li class="nav-item">
                            <a href="{{ url('/villages') }}" class="nav-link {{ Request::is('villages*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-map-marker-alt"></i>
                                <p>
                                    Kelurahan
                                </p>
                            </a>
                        </li>
                    @endcan

                    @can('berita_admin')
                        <li class="nav-item">
                            <a href="{{ url('/news') }}" class="nav-link {{ Request::is('news*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-newspaper"></i>
                                <p>
                                    Berita
                                </p>
                            </a>
                        </li>
                    @endcan

                @endif
            </ul>
        </nav>


    </div>
</aside>
