<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login - SIMPUS</title>
  <link rel="stylesheet" href="{{ asset('vendors/feather/feather.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/ti-icons/css/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.base.css') }}">
  <link rel="stylesheet" href="{{ asset('css/vertical-layout-light/style.css') }}">
  <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">
                {{-- Anda bisa ganti logo ini --}}
                <img src="{{ asset('images/logo.svg') }}" alt="logo">
              </div>
              <h4>Halo! Mari kita mulai</h4>
              <h6 class="font-weight-light">Masuk untuk melanjutkan.</h6>

              {{-- INILAH BAGIAN PENTINGNYA! --}}
              {{-- Form ini akan mengirim data ke rute 'login' yang dibuat oleh Breeze --}}
              <form class="pt-3" method="POST" action="{{ route('login') }}">
                {{-- @csrf adalah token keamanan wajib dari Laravel --}}
                @csrf

                <div class="form-group">
                  {{-- Input untuk email, perhatikan atribut 'name="email"' --}}
                  <input type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror" id="exampleInputEmail1" placeholder="Email" value="{{ old('email') }}" required autofocus>

                  {{-- Blok ini akan menampilkan error jika validasi email gagal --}}
                  @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>

                <div class="form-group">
                  {{-- Input untuk password, perhatikan atribut 'name="password"' --}}
                  <input type="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" id="exampleInputPassword1" placeholder="Password" required>

                   {{-- Blok ini akan menampilkan error jika validasi password gagal --}}
                   @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>

                <div class="mt-3">
                  {{-- Tombol Login, tipenya harus 'submit' --}}
                  <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                    SIGN IN
                  </button>
                </div>

                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      {{-- Checkbox "Remember Me" --}}
                      <input type="checkbox" class="form-check-input" name="remember">
                      Ingat saya
                    </label>
                  </div>
                  {{-- Jika Anda butuh fitur lupa password, bisa diaktifkan nanti --}}
                  {{-- <a href="#" class="auth-link text-black">Lupa password?</a> --}}
                </div>

                {{-- Link ke halaman registrasi jika dibutuhkan --}}
                {{-- <div class="text-center mt-4 font-weight-light">
                  Belum punya akun? <a href="{{ route('register') }}" class="text-primary">Buat</a>
                </div> --}}
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
  <script src="{{ asset('js/settings.js') }}"></script>
  <script src="{{ asset('js/todolist.js') }}"></script>
  </body>

</html>
