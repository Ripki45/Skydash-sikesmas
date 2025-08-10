<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register - SIMPUS</title>

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

                            <div class="brand-logo text-center mb-4">
                                <h4>Buat Akun Baru</h4>
                                <h6 class="font-weight-light">Isi data di bawah ini untuk mendaftar.</h6>
                            </div>

                            <form class="pt-3" method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="form-group">
                                    <input type="text" name="name" class="form-control form-control-lg @error('name') is-invalid @enderror" placeholder="Nama Lengkap" value="{{ old('name') }}" required autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <select name="desa_id" id="desa" class="form-control form-control-lg @error('desa_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Desa --</option>
                                        @foreach ($desas as $desa)
                                            <option value="{{ $desa->id }}" {{ old('desa_id') == $desa->id ? 'selected' : '' }}>{{ $desa->nama_desa }}</option>
                                        @endforeach
                                    </select>
                                    @error('desa_id')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <select name="dusun_id" id="dusun" class="form-control form-control-lg @error('dusun_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Dusun --</option>
                                    </select>
                                    @error('dusun_id')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <input type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <input type="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" placeholder="Password" required>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <input type="password" name="password_confirmation" class="form-control form-control-lg" placeholder="Konfirmasi Password" required>
                                </div>

                                <div class="mt-3">
                                    <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">REGISTER</button>
                                </div>

                                <div class="text-center mt-4 font-weight-light">
                                    Sudah punya akun? <a href="{{ route('login') }}" class="text-primary">Login</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#desa').on('change', function() {
            var desaID = $(this).val();
            if(desaID) {
                $.ajax({
                    url: '{{ route("getDusuns") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        desa_id: desaID
                    },
                    dataType: 'json',
                    success:function(data) {
                        $('#dusun').empty().append('<option value="">-- Pilih Dusun --</option>');
                        $.each(data, function(key, value) {
                            $('#dusun').append('<option value="'+ value.id +'">'+ value.nama_dusun +'</option>');
                        });
                    }
                });
            } else {
                $('#dusun').empty().append('<option value="">-- Pilih Dusun --</option>');
            }
        });
    });
    </script>
</body>
</html>
