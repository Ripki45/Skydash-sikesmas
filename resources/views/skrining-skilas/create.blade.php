@extends('layouts.app')

@section('content')
<form action="{{ route('skrining-skilas.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Formulir Skrining SKILAS</h4>

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
                                <input type="date" name="tanggal_skrining" class="form-control" value="{{ date('Y-m-d') }}" required>
                                <small class="form-text text-muted">Tanggal pelaksanaan skrining.</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Diinput Oleh</label>
                                <input type="text" class="form-control" value="{{ Auth::user()->name }} ({{ Auth::user()->roles->first()->display_name }})" disabled>
                                <small class="form-text text-muted">Nama Anda sebagai penginput data.</small>
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
                    <div class="form-group"><label>NIK</label><input type="text" name="nik" class="form-control" placeholder="16 digit NIK" required><small class="form-text text-muted">Wajib diisi sesuai KTP.</small></div>
                    <div class="form-group"><label>Nama Lengkap</label><input type="text" name="nama_lengkap" class="form-control" required><small class="form-text text-muted">Nama sesuai KTP.</small></div>
                    <div class="form-group"><label>Tanggal Lahir</label><input type="date" name="tanggal_lahir" class="form-control" required></div>
                    <div class="form-group"><label>Jenis Kelamin</label><select name="jenis_kelamin" class="form-control"><option value="Laki-laki">Laki-laki</option><option value="Perempuan">Perempuan</option></select></div>
                    <div class="form-group"><label>No. HP</label><input type="text" name="no_hp" class="form-control" placeholder="Contoh: 0812xxxxxxxx"></div>
                    <div class="form-group"><label>Alamat</label><textarea name="alamat" class="form-control" rows="3" required placeholder="Alamat lengkap sesuai KTP"></textarea></div>
                    <div class="row">
                        <div class="col-md-4"><div class="form-group"><label>RT</label><input type="text" name="rt" class="form-control" required></div></div>
                        <div class="col-md-4"><div class="form-group"><label>RW</label><input type="text" name="rw" class="form-control" required></div></div>
                        <div class="col-md-4"><div class="form-group"><label>Kelurahan</label><input type="text" name="kelurahan" class="form-control" required></div></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIWAYAT PENYAKIT & KONSUMSI MAKANAN --}}
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">2. Riwayat Penyakit</h4>
                    <p class="text-muted">Centang jika pasien sedang atau pernah menderita penyakit berikut.</p>
                    <div class="form-check"><label class="form-check-label"><input type="checkbox" name="riwayat_ginjal" value="1" class="form-check-input"> Gangguan Ginjal</label></div>
                    <div class="form-check"><label class="form-check-label"><input type="checkbox" name="riwayat_penglihatan" value="1" class="form-check-input"> Gangguan Penglihatan</label></div>
                    <div class="form-check"><label class="form-check-label"><input type="checkbox" name="riwayat_pendengaran" value="1" class="form-check-input"> Gangguan Pendengaran</label></div>
                    <hr>
                    <h4 class="card-title mt-4">3. Konsumsi Makanan Harian</h4>
                    <p class="text-muted">Centang jika pasien mengonsumsi jenis makanan berikut setiap hari.</p>
                    <div class="form-check"><label class="form-check-label"><input type="checkbox" name="konsumsi_pokok" value="1" class="form-check-input"> Makanan Pokok (Nasi/Sagu/Jagung)</label></div>
                    <div class="form-check"><label class="form-check-label"><input type="checkbox" name="konsumsi_lauk" value="1" class="form-check-input"> Lauk Pauk (Ikan/Daging/Telur)</label></div>
                    <div class="form-check"><label class="form-check-label"><input type="checkbox" name="konsumsi_sayur" value="1" class="form-check-input"> Sayuran</label></div>
                    <div class="form-check"><label class="form-check-label"><input type="checkbox" name="konsumsi_buah" value="1" class="form-check-input"> Buah</label></div>
                </div>
            </div>
        </div>

        {{-- PEMERIKSAAN FISIK & LAB --}}
        <div class="col-12 grid-margin">
             <div class="card">
                <div class="card-body">
                    <p class="alert alert-info">Isi bagian ini sesuai hasil pengukuran. Kosongkan jika tidak ada data.</p>
                    <div class="row">
                        <div class="col-md-6">
                             <h4 class="card-title">4. Pemeriksaan Fisik</h4>
                             <div class="form-group row"><label class="col-sm-4 col-form-label">Tekanan Darah</label><div class="col-sm-4"><input type="number" name="td_sistolik" class="form-control" placeholder="Sistolik (atas)"></div><div class="col-sm-4"><input type="number" name="td_diastolik" class="form-control" placeholder="Diastolik (bawah)"></div></div>
                             <div class="form-group row"><label class="col-sm-4 col-form-label">Berat Badan (kg)</label><div class="col-sm-8"><input type="number" step="0.1" name="berat_badan" class="form-control" placeholder="Contoh: 55.5"></div></div>
                             <div class="form-group row"><label class="col-sm-4 col-form-label">Tinggi Badan (cm)</label><div class="col-sm-8"><input type="number" step="0.1" name="tinggi_badan" class="form-control" placeholder="Contoh: 160.5"></div></div>
                             <div class="form-group row"><label class="col-sm-4 col-form-label">IMT</label><div class="col-sm-8"><input type="number" step="0.1" name="imt" class="form-control" placeholder="Hasil Indeks Massa Tubuh"></div></div>
                             <div class="form-group row"><label class="col-sm-4 col-form-label">Lingkar Lengan (cm)</label><div class="col-sm-8"><input type="number" step="0.1" name="lila" class="form-control" placeholder="Contoh: 23.5"></div></div>
                        </div>
                        <div class="col-md-6">
                            <h4 class="card-title">5. Pemeriksaan Laboratorium</h4>
                            <small class="text-muted d-block mb-3">
                                Isikan hasil laboratorium terbaru pasien. Centang risiko jika hasil di luar batas normal. Satuan sesuai standar pemeriksaan.
                            </small>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Gula Darah</label>
                            <div class="col-sm-8">
                            <input type="number" name="gds" class="form-control">
                            <small class="form-text text-muted">Batas normal puasa: 70–110 mg/dL. Di atas 200 mg/dL (GDS) → curiga diabetes.</small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Kolesterol</label>
                            <div class="col-sm-8">
                            <input type="number" name="kolesterol" class="form-control">
                            <small class="form-text text-muted">Normal: &lt;200 mg/dL. Di atas 240 mg/dL → risiko tinggi.</small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Asam Urat</label>
                            <div class="col-sm-8">
                            <input type="number" step="0.1" name="asam_urat" class="form-control">
                            <small class="form-text text-muted">Pria: &lt;7 mg/dL, Wanita: &lt;6 mg/dL. Di atas itu → hiperurisemia.</small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">HB</label>
                            <div class="col-sm-8">
                            <input type="number" step="0.1" name="hb" class="form-control">
                            <small class="form-text text-muted">Normal: ≥12 gr/dL (wanita) atau ≥13 gr/dL (pria). Di bawah itu → curiga anemia.</small>
                            </div>
                        </div>
                    </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Aktivitas Kehidupan Sehari-hari (AKS / ADL)</h4>
                    <p class="text-muted">Pilih tingkat kemandirian pasien untuk setiap aktivitas. (Default: Mandiri)</p>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <p class="font-weight-bold mb-1">1. Mengendalikan rangsang BAB</p>
                            <div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="adl_bab" value="0"> Tergantung</label></div>
                            <div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="adl_bab" value="1"> Bantuan</label></div>
                            <div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="adl_bab" value="2" checked> Mandiri</label></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <p class="font-weight-bold mb-1">2. Mengendalikan rangsang BAK</p>
                            <div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="adl_bak" value="0"> Tergantung</label></div>
                            <div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="adl_bak" value="1"> Bantuan</label></div>
                            <div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="adl_bak" value="2" checked> Mandiri</label></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <p class="font-weight-bold mb-1">3. Membersihkan diri (cuci muka, sisir)</p>
                            <div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="adl_membersihkan_diri" value="0"> Bantuan</label></div>
                            <div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="adl_membersihkan_diri" value="1" checked> Mandiri</label></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <p class="font-weight-bold mb-1">4. Penggunaan WC</p>
                            <div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="adl_wc" value="0"> Tergantung</label></div>
                            <div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="adl_wc" value="1"> Bantuan</label></div>
                            <div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="adl_wc" value="2" checked> Mandiri</label></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <p class="font-weight-bold mb-1">5. Makan & Minum</p>
                            <div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="adl_makan_minum" value="0"> Tergantung</label></div>
                            <div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="adl_makan_minum" value="1"> Bantuan</label></div>
                            <div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="adl_makan_minum" value="2" checked> Mandiri</label></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <p class="font-weight-bold mb-1">6. Berubah sikap (berbaring ke duduk)</p>
                            <div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="adl_berbaring_duduk" value="0"> Tergantung</label></div>
                            <div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="adl_berbaring_duduk" value="1"> Bantuan</label></div>
                            <div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="adl_berbaring_duduk" value="2" checked> Mandiri</label></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <p class="font-weight-bold mb-1">7. Berjalan atau berpindah</p>
                            <div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="adl_berjalan" value="0"> Tergantung</label></div>
                            <div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="adl_berjalan" value="1"> Bantuan</label></div>
                            <div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="adl_berjalan" value="2" checked> Mandiri</label></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <p class="font-weight-bold mb-1">8. Berpakaian</p>
                            <div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="adl_berpakaian" value="0"> Tergantung</label></div>
                            <div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="adl_berpakaian" value="1"> Bantuan</label></div>
                            <div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="adl_berpakaian" value="2" checked> Mandiri</label></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <p class="font-weight-bold mb-1">9. Naik turun tangga</p>
                            <div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="adl_naik_tangga" value="0"> Tergantung</label></div>
                            <div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="adl_naik_tangga" value="1"> Bantuan</label></div>
                            <div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="adl_naik_tangga" value="2" checked> Mandiri</label></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <p class="font-weight-bold mb-1">10. Mandi</p>
                            <div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="adl_mandi" value="0"> Tergantung</label></div>
                            <div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="adl_mandi" value="1" checked> Mandiri</label></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- KUESIONER SKILAS --}}
        <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
            <h4 class="card-title">6. Instrumen Skrining SKILAS</h4>
            <p class="alert alert-warning">
                <strong>Perhatian!</strong> Centang kotak jika jawaban pasien menunjukkan adanya <strong>risiko</strong> (misalnya jawaban "Salah", "Tidak Bisa", "Ya, BB turun", dll).
            </p>

            <div class="row">

                <!-- Penurunan Kognitif -->
                <div class="col-md-4">
                <h5 class="font-weight-bold">Penurunan Kognitif</h5>
                <small class="text-muted d-block mb-2">
                    Tanyakan hari, tanggal, lokasi, dan minta pasien mengulang 3 kata. Centang bila jawaban salah.
                </small>
                <div class="form-check"><label class="form-check-label"><input type="checkbox" name="skilas_kognitif_tanggal_salah" value="1" class="form-check-input"> Salah menjawab tanggal/hari/bulan/tahun</label></div>
                <div class="form-check"><label class="form-check-label"><input type="checkbox" name="skilas_kognitif_lokasi_salah" value="1" class="form-check-input"> Salah menjawab lokasi saat ini</label></div>
                <div class="form-check"><label class="form-check-label"><input type="checkbox" name="skilas_kognitif_kata_salah" value="1" class="form-check-input"> Tidak bisa mengulang 3 kata</label></div>
                </div>

                <!-- Mobilitas -->
                <div class="col-md-4">
                <h5 class="font-weight-bold">Keterbatasan Mobilitas</h5>
                <small class="text-muted d-block mb-2">
                    Minta pasien berdiri dari kursi tanpa tangan sebanyak 5x. Hitung waktunya.
                </small>
                <div class="form-check"><label class="form-check-label"><input type="checkbox" name="skilas_mobilitas_terbatas" value="1" class="form-check-input"> Tidak bisa berdiri dari kursi 5x (&lt;14 dtk)</label></div>
                </div>

                <!-- Malnutrisi -->
                <div class="col-md-4">
                <h5 class="font-weight-bold">Malnutrisi</h5>
                <small class="text-muted d-block mb-2">
                    Tanyakan apakah berat badan turun, nafsu makan menurun, dan ukur LILA.
                </small>
                <div class="form-check"><label class="form-check-label"><input type="checkbox" name="skilas_malnutrisi_bb_turun" value="1" class="form-check-input"> BB turun >3kg / 3 bln</label></div>
                <div class="form-check"><label class="form-check-label"><input type="checkbox" name="skilas_malnutrisi_nafsu_makan" value="1" class="form-check-input"> Hilang nafsu makan</label></div>
                <div class="form-check"><label class="form-check-label"><input type="checkbox" name="skilas_malnutrisi_lila_rendah" value="1" class="form-check-input"> LiLA &lt;21 cm</label></div>
                </div>

                <!-- Penglihatan -->
                <div class="col-md-4 mt-3">
                <h5 class="font-weight-bold">Gangguan Penglihatan</h5>
                <small class="text-muted d-block mb-2">
                    Tanyakan keluhan dan lakukan tes jari dari jarak 3 meter.
                </small>
                <div class="form-check"><label class="form-check-label"><input type="checkbox" name="skilas_penglihatan_buram" value="1" class="form-check-input"> Mengeluh penglihatan buram</label></div>
                <div class="form-check"><label class="form-check-label"><input type="checkbox" name="skilas_penglihatan_tes_jari" value="1" class="form-check-input"> Gagal tes hitung jari</label></div>
                </div>

                <!-- Pendengaran -->
                <div class="col-md-4 mt-3">
                <h5 class="font-weight-bold">Gangguan Pendengaran</h5>
                <small class="text-muted d-block mb-2">
                    Lakukan tes bisik dari jarak ±60 cm, tutup satu telinga.
                </small>
                <div class="form-check"><label class="form-check-label"><input type="checkbox" name="skilas_pendengaran_terganggu" value="1" class="form-check-input"> Gagal tes bisik</label></div>
                </div>

                <!-- Depresi -->
                <div class="col-md-4 mt-3">
                <h5 class="font-weight-bold">Gejala Depresi</h5>
                <small class="text-muted d-block mb-2">
                    Tanyakan perasaan pasien 2 minggu terakhir. Centang jika jawaban menunjukkan gejala.
                </small>
                <div class="form-check"><label class="form-check-label"><input type="checkbox" name="skilas_depresi_sedih" value="1" class="form-check-input"> Merasa sedih/putus asa</label></div>
                <div class="form-check"><label class="form-check-label"><input type="checkbox" name="skilas_depresi_kurang_semangat" value="1" class="form-check-input"> Kurang semangat beraktivitas</label></div>
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
                     <div class="form-check mb-3"><label class="form-check-label"><input type="checkbox" name="tindak_lanjut_rujukan" value="1" class="form-check-input"> Perlu Rujukan Internal / Eksternal</label></div>
                     <div class="form-group"><label>Tujuan Rujukan</label><input type="text" name="tujuan_rujukan" class="form-control" placeholder="Contoh: Poli Lansia Puskesmas"></div>
                     <div class="form-group"><label>Alasan Rujukan</label><textarea name="alasan_rujukan" class="form-control" rows="3" placeholder="Contoh: Ditemukan 3 atau lebih risiko SKILAS"></textarea></div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary btn-lg">Simpan Hasil Skrining</button>
            <a href="{{ route('skrining-skilas.index') }}" class="btn btn-light">Batal</a>
        </div>
    </div>
</form>
@endsection
