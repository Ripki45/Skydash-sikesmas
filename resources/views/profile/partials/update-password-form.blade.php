<section>
    <header>
        <h4 class="card-title">Perbarui Password</h4>
        <p class="card-description">
            Pastikan akun Anda menggunakan password yang panjang dan acak agar tetap aman.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-4">
        @csrf
        @method('put')

        <div class="form-group">
            <label for="current_password">Password Saat Ini</label>
            <input id="current_password" name="current_password" type="password" class="form-control" autocomplete="current-password">
        </div>

        <div class="form-group">
            <label for="password">Password Baru</label>
            <input id="password" name="password" type="password" class="form-control" autocomplete="new-password">
        </div>

        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password Baru</label>
            <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password">
        </div>

        <div class="d-flex align-items-center gap-4">
            <button type="submit" class="btn btn-primary">Simpan</button>

            @if (session('status') === 'password-updated')
                <p class="text-success ml-3">Tersimpan.</p>
            @endif
        </div>
    </form>
</section>
