<section>
    <header>
        <h4 class="card-title">Informasi Profil</h4>
        <p class="card-description">
            Perbarui informasi profil dan alamat email akun Anda.
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-4">
        @csrf
        @method('patch')

        <div class="form-group">
            <label for="name">Nama</label>
            <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            {{-- Tampilkan error jika ada --}}
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="username">
            {{-- Tampilkan error jika ada --}}
        </div>

        <div class="d-flex align-items-center gap-4">
            <button type="submit" class="btn btn-primary">Simpan</button>

            @if (session('status') === 'profile-updated')
                <p class="text-success ml-3">Tersimpan.</p>
            @endif
        </div>
    </form>
</section>
