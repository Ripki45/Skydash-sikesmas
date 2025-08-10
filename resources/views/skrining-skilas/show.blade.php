@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title">Detail Hasil Skrining SKILAS</h4>
                    <div>
                        <a href="{{ route('admin.skrining-skilas.index') }}" class="btn btn-light">Kembali</a>
                        <a href="{{ route('admin.skrining-skilas.edit', $skrining->id) }}" class="btn btn-warning">Edit</a>
                        <button onclick="window.print()" class="btn btn-primary">Cetak</button>
                    </div>
                </div>

                {{-- INFORMASI PENGINPUT --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Tanggal Skrining:</strong><br>{{ \Carbon\Carbon::parse($skrining->tanggal_skrining)->isoFormat('dddd, D MMMM Y') }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Diinput Oleh:</strong><br>{{ $skrining->user->name }} ({{ $skrining->user->roles->first()->display_name }})</p>
                    </div>
                </div>
                <hr>

                {{-- IDENTITAS PASIEN --}}
                <h5 class="card-title">1. Identitas Pasien</h5>
                <div class="row">
                    <div class="col-md-6"><p><strong>NIK:</strong><br>{{ $skrining->nik }}</p></div>
                    <div class="col-md-6"><p><strong>Nama Lengkap:</strong><br>{{ $skrining->nama_lengkap }}</p></div>
                    <div class="col-md-6"><p><strong>Tanggal Lahir:</strong><br>{{ \Carbon\Carbon::parse($skrining->tanggal_lahir)->isoFormat('D MMMM Y') }} (Usia: {{ \Carbon\Carbon::parse($skrining->tanggal_lahir)->age }} Thn)</p></div>
                    <div class="col-md-6"><p><strong>Jenis Kelamin:</strong><br>{{ $skrining->jenis_kelamin }}</p></div>
                    <div class="col-md-6"><p><strong>Alamat:</strong><br>{{ $skrining->alamat }}, RT {{ $skrining->rt }}/RW {{ $skrining->rw }}, Kel. {{ $skrining->kelurahan }}</p></div>
                </div>
                <hr>

                {{-- KUESIONER SKILAS --}}
                <h5 class="card-title">2. Hasil Skrining SKILAS (Risiko Terdeteksi)</h5>
                <div class="row">
                    <div class="col-md-4"><strong>Penurunan Kognitif:</strong>
                        <ul>
                            @if($skrining->skilas_kognitif_tanggal_salah) <li>Salah tanggal/hari</li> @endif
                            @if($skrining->skilas_kognitif_lokasi_salah) <li>Salah lokasi</li> @endif
                            @if($skrining->skilas_kognitif_kata_salah) <li>Tidak bisa mengulang kata</li> @endif
                        </ul>
                    </div>
                    <div class="col-md-4"><strong>Keterbatasan Mobilitas:</strong>
                        <ul>@if($skrining->skilas_mobilitas_terbatas) <li>Tidak bisa berdiri 5x</li> @endif</ul>
                    </div>
                    <div class="col-md-4"><strong>Malnutrisi:</strong>
                        <ul>
                            @if($skrining->skilas_malnutrisi_bb_turun) <li>BB turun >3kg</li> @endif
                            @if($skrining->skilas_malnutrisi_nafsu_makan) <li>Nafsu makan turun</li> @endif
                            @if($skrining->skilas_malnutrisi_lila_rendah) <li>LiLA &lt;21 cm</li> @endif
                        </ul>
                    </div>
                    <div class="col-md-4"><strong>Gangguan Penglihatan:</strong>
                        <ul>
                            @if($skrining->skilas_penglihatan_buram) <li>Mengeluh buram</li> @endif
                            @if($skrining->skilas_penglihatan_tes_jari) <li>Gagal tes jari</li> @endif
                        </ul>
                    </div>
                    <div class="col-md-4"><strong>Gangguan Pendengaran:</strong>
                        <ul>@if($skrining->skilas_pendengaran_terganggu) <li>Gagal tes bisik</li> @endif</ul>
                    </div>
                    <div class="col-md-4"><strong>Gejala Depresi:</strong>
                        <ul>
                            @if($skrining->skilas_depresi_sedih) <li>Merasa sedih</li> @endif
                            @if($skrining->skilas_depresi_kurang_semangat) <li>Kurang semangat</li> @endif
                        </ul>
                    </div>
                </div>
                <hr>

                {{-- PEMERIKSAAN FISIK & LAB --}}
                 <div class="row">
                    <div class="col-md-6">
                        <h5 class="card-title">3. Pemeriksaan Fisik</h5>
                        <p><strong>Tekanan Darah:</strong> {{ $skrining->td_sistolik }}/{{ $skrining->td_diastolik }} mmHg</p>
                        <p><strong>Berat/Tinggi Badan:</strong> {{ $skrining->berat_badan }} kg / {{ $skrining->tinggi_badan }} cm</p>
                        <p><strong>IMT:</strong> {{ $skrining->imt }}</p>
                        <p><strong>Lingkar Lengan (LiLA):</strong> {{ $skrining->lila }} cm</p>
                    </div>
                    <div class="col-md-6">
                         <h5 class="card-title">4. Laboratorium</h5>
                         <p><strong>Gula Darah:</strong> {{ $skrining->gds }} mg/dL</p>
                         <p><strong>Kolesterol:</strong> {{ $skrining->kolesterol }} mg/dL</p>
                         <p><strong>Asam Urat:</strong> {{ $skrining->asam_urat }} mg/dL</p>
                         <p><strong>HB:</strong> {{ $skrining->hb }} g/dL</p>
                    </div>
                </div>
                <hr>

                {{-- TINDAK LANJUT --}}
                <h5 class="card-title">5. Tindak Lanjut</h5>
                <p><strong>Perlu Rujukan:</strong> {{ $skrining->tindak_lanjut_rujukan ? 'Ya' : 'Tidak' }}</p>
                @if($skrining->tindak_lanjut_rujukan)
                    <p><strong>Tujuan Rujukan:</strong><br>{{ $skrining->tujuan_rujukan }}</p>
                    <p><strong>Alasan Rujukan:</strong><br>{{ $skrining->alasan_rujukan }}</p>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
