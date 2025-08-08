@extends('layouts.app')

@section('content')
<form action="{{ route('skrining-skilas.update', $skrining->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Hasil Skrining SKILAS</h4>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops! Ada yang salah dengan input Anda.</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- INFORMASI PENGINPUT --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Skrining</label>
                                <input type="date" name="tanggal_skrining" class="form-control" value="{{ old('tanggal_skrining', $skrining->tanggal_skrining) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Diinput Oleh</label>
                                <input type="text" class="form-control" value="{{ $skrining->user->name }} ({{ $skrining->user->roles->first()->display_name }})" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- IDENTITAS PASIEN --}}
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">1. Identitas Pasien</h4>
                    <div class="form-group"><label>NIK</label><input type="text" name="nik" class="form-control" value="{{ old('nik', $skrining->nik) }}" required></div>
                    <div class="form-group"><label>Nama Lengkap</label><input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $skrining->nama_lengkap) }}" required></div>
                    <div class="form-group"><label>Tanggal Lahir</label><input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $skrining->tanggal_lahir) }}" required></div>
                    <div class="form-group"><label>Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control">
                            <option value="Laki-laki" {{ old('jenis_kelamin', $skrining->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin', $skrining->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group"><label>No. HP</label><input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $skrining->no_hp) }}"></div>
                    <div class="form-group"><label>Alamat</label><textarea name="alamat" class="form-control" rows="3" required>{{ old('alamat', $skrining->alamat) }}</textarea></div>
                    <div class="row">
                        <div class="col-md-4"><div class="form-group"><label>RT</label><input type="text" name="rt" class="form-control" value="{{ old('rt', $skrining->rt) }}" required></div></div>
                        <div class="col-md-4"><div class="form-group"><label>RW</label><input type="text" name="rw" class="form-control" value="{{ old('rw', $skrining->rw) }}" required></div></div>
                        <div class="col-md-4"><div class="form-group"><label>Kelurahan</label><input type="text" name="kelurahan" class="form-control" value="{{ old('kelurahan', $skrining->kelurahan) }}" required></div></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIWAYAT PENYAKIT & KONSUMSI MAKANAN --}}
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">2. Riwayat Penyakit</h4>
                    <div class="form-check"><label class="form-check-label"><input type="checkbox" name="riwayat_ginjal" value="1" class="form-check-input" @if(old('riwayat_ginjal', $skrining->riwayat_ginjal)) checked @endif> Gangguan Ginjal</label></div>
                    <div class="form-check"><label class="form-check-label"><input type="checkbox" name="riwayat_penglihatan" value="1" class="form-check-input" @if(old('riwayat_penglihatan', $skrining->riwayat_penglihatan)) checked @endif> Gangguan Penglihatan</label></div>
                    <div class="form-check"><label class="form-check-label"><input type="checkbox" name="riwayat_pendengaran" value="1" class="form-check-input" @if(old('riwayat_pendengaran', $skrining->riwayat_pendengaran)) checked @endif> Gangguan Pendengaran</label></div>
                    <hr>
                    <h4 class="card-title mt-4">3. Konsumsi Makanan Harian</h4>
                    <div class="form-check"><label class="form-check-label"><input type="checkbox" name="konsumsi_pokok" value="1" class="form-check-input" @if(old('konsumsi_pokok', $skrining->konsumsi_pokok)) checked @endif> Makanan Pokok</label></div>
                    <div class="form-check"><label class="form-check-label"><input type="checkbox" name="konsumsi_lauk" value="1" class="form-check-input" @if(old('konsumsi_lauk', $skrining->konsumsi_lauk)) checked @endif> Lauk Pauk</label></div>
                    <div class="form-check"><label class="form-check-label"><input type="checkbox" name="konsumsi_sayur" value="1" class="form-check-input" @if(old('konsumsi_sayur', $skrining->konsumsi_sayur)) checked @endif> Sayuran</label></div>
                    <div class="form-check"><label class="form-check-label"><input type="checkbox" name="konsumsi_buah" value="1" class="form-check-input" @if(old('konsumsi_buah', $skrining->konsumsi_buah)) checked @endif> Buah</label></div>
                </div>
            </div>
        </div>

        {{-- PEMERIKSAAN FISIK & LAB --}}
        <div class="col-12 grid-margin">
             <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                             <h4 class="card-title">4. Pemeriksaan Fisik</h4>
                             <div class="form-group row"><label class="col-sm-4 col-form-label">Tekanan Darah</label><div class="col-sm-4"><input type="number" name="td_sistolik" class="form-control" value="{{ old('td_sistolik', $skrining->td_sistolik) }}" placeholder="Atas"></div><div class="col-sm-4"><input type="number" name="td_diastolik" class="form-control" value="{{ old('td_diastolik', $skrining->td_diastolik) }}" placeholder="Bawah"></div></div>
                             <div class="form-group row"><label class="col-sm-4 col-form-label">Berat Badan (kg)</label><div class="col-sm-8"><input type="number" step="0.1" name="berat_badan" class="form-control" value="{{ old('berat_badan', $skrining->berat_badan) }}" placeholder="Contoh: 55.5"></div></div>
                             <div class="form-group row"><label class="col-sm-4 col-form-label">Tinggi Badan (cm)</label><div class="col-sm-8"><input type="number" step="0.1" name="tinggi_badan" class="form-control" value="{{ old('tinggi_badan', $skrining->tinggi_badan) }}" placeholder="Contoh: 160.5"></div></div>
                             <div class="form-group row"><label class="col-sm-4 col-form-label">IMT</label><div class="col-sm-8"><input type="number" step="0.1" name="imt" class="form-control" value="{{ old('imt', $skrining->imt) }}"></div></div>
                             <div class="form-group row"><label class="col-sm-4 col-form-label">LiLA (cm)</label><div class="col-sm-8"><input type="number" step="0.1" name="lila" class="form-control" value="{{ old('lila', $skrining->lila) }}" placeholder="Contoh: 23.5"></div></div>
                        </div>
                        <div class="col-md-6">
                            <h4 class="card-title">5. Pemeriksaan Laboratorium</h4>
                            <div class="form-group row"><label class="col-sm-4 col-form-label">Gula Darah</label><div class="col-sm-8"><input type="number" name="gds" class="form-control" value="{{ old('gds', $skrining->gds) }}"></div></div>
                            <div class="form-group row"><label class="col-sm-4 col-form-label">Kolesterol</label><div class="col-sm-8"><input type="number" name="kolesterol" class="form-control" value="{{ old('kolesterol', $skrining->kolesterol) }}"></div></div>
                            <div class="form-group row"><label class="col-sm-4 col-form-label">Asam Urat</label><div class="col-sm-8"><input type="number" step="0.1" name="asam_urat" class="form-control" value="{{ old('asam_urat', $skrining->asam_urat) }}"></div></div>
                            <div class="form-group row"><label class="col-sm-4 col-form-label">HB</label><div class="col-sm-8"><input type="number" step="0.1" name="hb" class="form-control" value="{{ old('hb', $skrining->hb) }}"></div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- KUESIONER ADL --}}
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Aktivitas Kehidupan Sehari-hari (AKS/ADL)</h4>
                    <div class="row">
                         @php
                            $adl_options = [
                                'adl_bab' => '1. Mengendalikan rangsang BAB',
                                'adl_bak' => '2. Mengendalikan rangsang BAK',
                                'adl_membersihkan_diri' => '3. Membersihkan diri',
                                'adl_wc' => '4. Penggunaan WC',
                                'adl_makan_minum' => '5. Makan & Minum',
                                'adl_berbaring_duduk' => '6. Berubah sikap',
                                'adl_berjalan' => '7. Berjalan/berpindah',
                                'adl_berpakaian' => '8. Berpakaian',
                                'adl_naik_tangga' => '9. Naik turun tangga',
                                'adl_mandi' => '10. Mandi',
                            ];
                        @endphp
                        @foreach($adl_options as $key => $label)
                        <div class="col-md-6 mb-3">
                            <p class="font-weight-bold mb-1">{{ $label }}</p>
                            <div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="{{ $key }}" value="0" @if(old($key, $skrining->$key) == 0) checked @endif> Tergantung</label></div>
                            @if(!in_array($key, ['adl_membersihkan_diri', 'adl_mandi']))
                            <div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="{{ $key }}" value="1" @if(old($key, $skrining->$key) == 1) checked @endif> Bantuan</label></div>
                            <div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="{{ $key }}" value="2" @if(old($key, $skrining->$key) == 2) checked @endif> Mandiri</label></div>
                            @else
                             <div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="{{ $key }}" value="1" @if(old($key, $skrining->$key) == 1) checked @endif> Mandiri</label></div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- KUESIONER SKILAS --}}
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">6. Instrumen Skrining SKILAS (Jawaban Berisiko = Centang)</h4>
                    <div class="row">
                        <div class="col-md-4"><h5 class="font-weight-bold">Penurunan Kognitif</h5>
                            <div class="form-check"><label class="form-check-label"><input type="checkbox" name="skilas_kognitif_tanggal_salah" value="1" @if(old('skilas_kognitif_tanggal_salah', $skrining->skilas_kognitif_tanggal_salah)) checked @endif class="form-check-input"> Salah menjawab tanggal</label></div>
                            <div class="form-check"><label class="form-check-label"><input type="checkbox" name="skilas_kognitif_lokasi_salah" value="1" @if(old('skilas_kognitif_lokasi_salah', $skrining->skilas_kognitif_lokasi_salah)) checked @endif class="form-check-input"> Salah menjawab lokasi</label></div>
                            <div class="form-check"><label class="form-check-label"><input type="checkbox" name="skilas_kognitif_kata_salah" value="1" @if(old('skilas_kognitif_kata_salah', $skrining->skilas_kognitif_kata_salah)) checked @endif class="form-check-input"> Tidak bisa mengulang kata</label></div>
                        </div>
                        <div class="col-md-4"><h5 class="font-weight-bold">Keterbatasan Mobilitas</h5>
                            <div class="form-check"><label class="form-check-label"><input type="checkbox" name="skilas_mobilitas_terbatas" value="1" @if(old('skilas_mobilitas_terbatas', $skrining->skilas_mobilitas_terbatas)) checked @endif class="form-check-input"> Tidak bisa berdiri 5x (&lt;14 dtk)</label></div>
                        </div>
                        <div class="col-md-4"><h5 class="font-weight-bold">Malnutrisi</h5>
                            <div class="form-check"><label class="form-check-label"><input type="checkbox" name="skilas_malnutrisi_bb_turun" value="1" @if(old('skilas_malnutrisi_bb_turun', $skrining->skilas_malnutrisi_bb_turun)) checked @endif class="form-check-input"> BB turun >3kg / 3 bln</label></div>
                            <div class="form-check"><label class="form-check-label"><input type="checkbox" name="skilas_malnutrisi_nafsu_makan" value="1" @if(old('skilas_malnutrisi_nafsu_makan', $skrining->skilas_malnutrisi_nafsu_makan)) checked @endif class="form-check-input"> Hilang nafsu makan</label></div>
                             <div class="form-check"><label class="form-check-label"><input type="checkbox" name="skilas_malnutrisi_lila_rendah" value="1" @if(old('skilas_malnutrisi_lila_rendah', $skrining->skilas_malnutrisi_lila_rendah)) checked @endif class="form-check-input"> LiLA &lt;21 cm</label></div>
                        </div>
                        <div class="col-md-4 mt-3"><h5 class="font-weight-bold">Gangguan Penglihatan</h5>
                            <div class="form-check"><label class="form-check-label"><input type="checkbox" name="skilas_penglihatan_buram" value="1" @if(old('skilas_penglihatan_buram', $skrining->skilas_penglihatan_buram)) checked @endif class="form-check-input"> Mengeluh penglihatan buram</label></div>
                            <div class="form-check"><label class="form-check-label"><input type="checkbox" name="skilas_penglihatan_tes_jari" value="1" @if(old('skilas_penglihatan_tes_jari', $skrining->skilas_penglihatan_tes_jari)) checked @endif class="form-check-input"> Gagal tes hitung jari</label></div>
                        </div>
                        <div class="col-md-4 mt-3"><h5 class="font-weight-bold">Gangguan Pendengaran</h5>
                            <div class="form-check"><label class="form-check-label"><input type="checkbox" name="skilas_pendengaran_terganggu" value="1" @if(old('skilas_pendengaran_terganggu', $skrining->skilas_pendengaran_terganggu)) checked @endif class="form-check-input"> Gagal tes bisik</label></div>
                        </div>
                        <div class="col-md-4 mt-3"><h5 class="font-weight-bold">Gejala Depresi</h5>
                            <div class="form-check"><label class="form-check-label"><input type="checkbox" name="skilas_depresi_sedih" value="1" @if(old('skilas_depresi_sedih', $skrining->skilas_depresi_sedih)) checked @endif class="form-check-input"> Merasa sedih/putus asa</label></div>
                            <div class="form-check"><label class="form-check-label"><input type="checkbox" name="skilas_depresi_kurang_semangat" value="1" @if(old('skilas_depresi_kurang_semangat', $skrining->skilas_depresi_kurang_semangat)) checked @endif class="form-check-input"> Kurang semangat beraktivitas</label></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TINDAK LANJUT --}}
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                     <h4 class="card-title">7. Tindak Lanjut</h4>
                     <div class="form-check mb-3"><label class="form-check-label"><input type="checkbox" name="tindak_lanjut_rujukan" value="1" @if(old('tindak_lanjut_rujukan', $skrining->tindak_lanjut_rujukan)) checked @endif class="form-check-input"> Perlu Rujukan</label></div>
                     <div class="form-group"><label>Tujuan Rujukan</label><input type="text" name="tujuan_rujukan" class="form-control" value="{{ old('tujuan_rujukan', $skrining->tujuan_rujukan) }}"></div>
                     <div class="form-group"><label>Alasan Rujukan</label><textarea name="alasan_rujukan" class="form-control" rows="3">{{ old('alasan_rujukan', $skrining->alasan_rujukan) }}</textarea></div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary btn-lg">Simpan Perubahan</button>
            <a href="{{ route('skrining-skilas.index') }}" class="btn btn-light">Batal</a>
        </div>
    </div>
</form>
@endsection
