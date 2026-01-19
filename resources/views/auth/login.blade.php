@extends('layouts.login')
@section('back')
    <div class="header is-fixed">
        <div class="tf-container">
            <div class="tf-statusbar d-flex justify-content-between align-items-center position-relative" style="height: 50px;">
                <div class="flex-item start" style="width: 50px; margin-top: -50px">
                    <a href="{{ url()->previous() ?? url('/') }}" class="back-btn"> <i class="icon-left"></i> </a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('container')
    <div id="app-wrap">
        <h1>Log In</h1>
        <br>
        <br>
        <form class="tf-form" action="{{ url('/login/store') }}" method="POST">
            @csrf
            <div class="group-input">
                <label>Email</label>
                <input type="email" placeholder="email" class="@error('email') is-invalid @enderror" value="{{ old('email') }}" name="email">
                @error('email')
                  <div class="invalid-feedback">
                      {{ $message }}
                  </div>
                @enderror
            </div>
            <div class="group-input auth-pass-input last">
                <label>Password</label>
                <input type="password" class="password-input @error('password') is-invalid @enderror" placeholder="Password" name="password">
                <a class="icon-eye password-addon" id="password-addon"></a>
                @error('password')
                  <div class="invalid-feedback">
                      {{ $message }}
                  </div>
                @enderror
            </div>

            <div class="group-input mt-4">
                <div class="icheck-primary">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember" class="mt-2">
                        Ingat Saya
                    </label>
                </div>
            </div>

            <button type="submit" class="tf-btn accent large">Log In</button>
            <div class="mt-2 text-right"> <a href="{{ url('/forgot-password') }}">Lupa Password <i class="fa fa-key ms-1"></i></a></div>
        </form>
    </div>


    <div class="auth-line">Or</div>
    <p class="mb-9 fw-3 text-center ">Belum punya akun? <a href="{{ url('/register') }}" class="auth-link-rg" >Daftar Sekarang</a></p>

    <button id="btnInstallPWA" type="submit" style="color: rgb(255, 135, 36); border:1px solid rgb(255, 135, 36);" class="tf-btn large"><i class="fa fa-download mr-1"></i> Install App</button>

    @push('script')
        <script>
            const btnInstall = document.getElementById('btnInstallPWA');
            let deferredPrompt = null;

            function isPWAInstalled() {
                return (
                    window.matchMedia('(display-mode: standalone)').matches ||
                    window.navigator.standalone === true ||
                    localStorage.getItem('pwaInstalled') === 'yes'
                );
            }

            function hideInstallButton() {
                if (btnInstall) btnInstall.style.display = 'none';
            }

            function showInstallButton() {
                if (btnInstall) btnInstall.style.display = 'block';
            }

            if (isPWAInstalled()) {
                hideInstallButton();
            } else {
                showInstallButton();
            }

            window.addEventListener('beforeinstallprompt', (e) => {
                if (isPWAInstalled()) return;

                e.preventDefault();
                deferredPrompt = e;
                showInstallButton();
            });

            btnInstall.addEventListener('click', async () => {
                if (!deferredPrompt) return;

                deferredPrompt.prompt();
                const { outcome } = await deferredPrompt.userChoice;

                if (outcome === 'accepted') {
                    localStorage.setItem('pwaInstalled', 'yes');
                    hideInstallButton();
                }

                deferredPrompt = null;
            });

            window.addEventListener('appinstalled', () => {
                localStorage.setItem('pwaInstalled', 'yes');
                hideInstallButton();
                console.log('PWA Installed');
            });
        </script>
    @endpush


@endsection
