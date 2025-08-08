<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login - {{ $settings['nama_puskesmas'] ?? 'SIMPUS' }}</title>

    <link rel="stylesheet" href="{{ asset('vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.base.css') }}">

    <link rel="stylesheet" href="{{ asset('css/vertical-layout-light/style.css') }}">

    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" />
</head>
<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">

                            <div class="brand-logo d-flex align-items-center justify-content-center mb-4">
                                @if(!empty($settings['logo_puskesmas']))
                                    <img src="{{ asset('storage/' . $settings['logo_puskesmas']) }}" alt="logo" style="height: 65px; width: auto; margin-right: 15px;">
                                @endif
                                <div style="text-align: left; line-height: 1.2;">
                                    <h2 class="mb-2 font-weight-bold">{{ $settings['nama_puskesmas'] ?? 'Nama Puskesmas' }}</h2>
                                    <h3 class="text-muted mb-0">{{ $settings['kecamatan'] ?? 'Kecamatan' }}</h3>
                                </div>
                            </div>

                            <form class="pt-3" method="POST" action="{{ route('login') }}">
                                @csrf
                                @if (session('error'))
                                    <div class="alert alert-danger" role="alert">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                <div class="form-group">
                                    <input type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" required autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" required>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <div class="mt-3">
                                    <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SIGN IN</button>
                                </div>

                                <div class="my-2 d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <label class="form-check-label text-muted">
                                            <input type="checkbox" class="form-check-input" name="remember"> Ingat saya
                                        </label>
                                    </div>
                                    <a href="{{ route('password.request') }}" class="auth-link text-black">Lupa password?</a>
                                </div>

                                <div class="mb-2 text-center">
                                    <p class="text-muted">atau</p>
                                 </div>

                                 <a href="{{ route('google.login') }}" class="btn btn-block btn-google auth-form-btn">
                                     <i class="ti-google"></i> Login dengan Google
                                 </a>

                                <div class="text-center mt-4 font-weight-light">
                                    Belum punya akun? <a href="{{ route('register') }}" class="text-primary">Buat Akun</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('js/off-canvas.js') }}"></script>
    <script src="{{ asset('js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>
</body>
</html>
