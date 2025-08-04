{{-- File: resources/views/partials/_jadwal-list.blade.php --}}
@forelse($jadwals as $jadwal)
    @php
        $colorClass = '';
        switch ($jadwal->jenis_kegiatan) {
            case 'Posyandu Balita': $colorClass = 'event-green'; break;
            case 'Posyandu Lansia': $colorClass = 'event-blue'; break;
            case 'Posyandu Remaja': $colorClass = 'event-pink'; break;
            case 'Posbindu PTM': $colorClass = 'event-yellow'; break;
        }
    @endphp
    <div class="event-item {{ $colorClass }}">
        <div class="event-date">
            <span>{{ $jadwal->tanggal_kegiatan->format('d') }}</span>
            {{ $jadwal->tanggal_kegiatan->format('M') }}
        </div>
        <div class="event-details">
            <h6 class="event-title">{{ $jadwal->nama_kegiatan }}</h6>
            <p class="event-meta">
                <i class="fas fa-flag"></i> {{ $jadwal->jenis_kegiatan }} <br>
                <i class="fas fa-map-marker-alt"></i> {{ $jadwal->posyandu->nama_posyandu }} ({{ $jadwal->posyandu->dusun->nama_dusun }})
            </p>
        </div>
    </div>
@empty
    <div class="alert alert-secondary">Tidak ada jadwal yang cocok dengan filter Anda.</div>
@endforelse
