@forelse ($jadwals as $jadwal)
    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            {{-- INILAH PERBAIKANNYA --}}
            {{-- Tampilkan jenis kegiatan sebagai badge --}}
            <span class="badge badge-info mb-2">{{ $jadwal->jenis_kegiatan }}</span>

            {{-- Tampilkan nama kegiatan yang lebih spesifik --}}
            <h6 class="card-title">{{ $jadwal->kegiatan }}</h6>

            <p class="card-text small text-muted mb-2">
                <i class="mdi mdi-calendar"></i> {{ \Carbon\Carbon::parse($jadwal->tanggal_kegiatan)->isoFormat('dddd, D MMMM Y') }}<br>
                <i class="mdi mdi-map-marker"></i> {{ $jadwal->posyandu->nama_posyandu ?? '-' }}
            </p>

            {{-- Tombol Interaktif --}}
            @if(in_array($jadwal->id, $confirmedIds))
                <button class="btn btn-success btn-sm w-100" disabled>
                    <i class="ti-check"></i> Anda Akan Hadir
                </button>
            @else
                <form action="{{ route('masyarakat.jadwal.konfirmasi', $jadwal->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        <i class="ti-thumb-up"></i> Saya Akan Hadir
                    </button>
                </form>
            @endif
        </div>
    </div>
@empty
    <div class="alert alert-light text-center">
        Tidak ada jadwal yang cocok dengan filter Anda.
    </div>
@endforelse
