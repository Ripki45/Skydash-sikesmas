@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-body">
        @if($halaman->gambar_unggulan)
            <img src="{{ asset('storage/' . $halaman->gambar_unggulan) }}" alt="{{ $halaman->judul }}" class="img-fluid mb-4" style="max-height: 400px; width: 100%; object-fit: cover;">
        @endif

        <h2 class="card-title">{{ $halaman->judul }}</h2>
        <p class="text-muted">Status: <span class="badge {{ $halaman->status == 'published' ? 'badge-success' : 'badge-warning' }}">{{ $halaman->status }}</span> | Dibuat pada: {{ $halaman->created_at->format('d M Y') }}</p>
        <hr>

        {{-- Menampilkan konten HTML --}}
        <div>
            {!! $halaman->konten !!}
        </div>

        <a href="{{ route('admin.halaman.index') }}" class="btn btn-light mt-4">Kembali ke Daftar Halaman</a>
    </div>
</div>
@endsection
