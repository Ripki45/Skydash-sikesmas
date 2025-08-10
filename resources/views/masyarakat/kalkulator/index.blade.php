
@extends('layouts.app')

@push('styles')
<style>
    .calculator-card {
        transition: all 0.3s ease-in-out;
    }
    .calculator-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 20px rgba(0,0,0,0.1) !important;
    }
    .result-display {
        background-color: #f8f9fa;
        border-left: 5px solid #007bff;
        padding: 1.5rem;
        margin-top: 1rem;
        display: none; /* Awalnya disembunyikan */
    }
    .result-display h3 {
        color: #007bff;
    }
    .result-display .bmi-category-underweight { border-left-color: #ffc107; }
    .result-display .bmi-category-underweight h3 { color: #ffc107; }
    .result-display .bmi-category-normal { border-left-color: #28a745; }
    .result-display .bmi-category-normal h3 { color: #28a745; }
    .result-display .bmi-category-overweight { border-left-color: #fd7e14; }
    .result-display .bmi-category-overweight h3 { color: #fd7e14; }
    .result-display .bmi-category-obese { border-left-color: #dc3545; }
    .result-display .bmi-category-obese h3 { color: #dc3545; }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin">
        <h3 class="font-weight-bold">Kalkulator Kesehatan</h3>
        <h6 class="font-weight-normal mb-0">Gunakan alat bantu ini untuk menghitung Indeks Massa Tubuh (IMT) dan Hari Perkiraan Lahir (HPL).</h6>
    </div>
</div>

<div class="row">
    <!-- Kalkulator IMT -->
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card calculator-card shadow-sm">
            <div class="card-body">
                <h4 class="card-title"><i class="mdi mdi-calculator"></i> Kalkulator Indeks Massa Tubuh (IMT)</h4>
                <p class="card-description">Ketahui status berat badan Anda.</p>
                <div class="form-group">
                    <label for="tinggi_badan">Tinggi Badan (cm)</label>
                    <input type="number" class="form-control" id="tinggi_badan" placeholder="Contoh: 165">
                </div>
                <div class="form-group">
                    <label for="berat_badan">Berat Badan (kg)</label>
                    <input type="number" class="form-control" id="berat_badan" placeholder="Contoh: 55">
                </div>
                <button type="button" id="hitung_imt" class="btn btn-primary">Hitung IMT</button>

                <div id="hasil_imt" class="result-display rounded">
                    <h3 class="font-weight-bold mb-2">Hasil IMT Anda: <span id="imt_value"></span></h3>
                    <p class="mb-1"><strong>Kategori: <span id="imt_category" class="font-weight-bold"></span></strong></p>
                    <p class="mb-0" id="imt_description"></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Kalkulator HPL -->
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card calculator-card shadow-sm">
            <div class="card-body">
                <h4 class="card-title"><i class="mdi mdi-calendar-heart"></i> Kalkulator Hari Perkiraan Lahir (HPL)</h4>
                <p class="card-description">Perkirakan tanggal lahir buah hati Anda.</p>
                <div class="form-group">
                    <label for="hpht">Hari Pertama Haid Terakhir (HPHT)</label>
                    <input type="date" class="form-control" id="hpht">
                </div>
                <button type="button" id="hitung_hpl" class="btn btn-primary">Hitung HPL</button>

                <div id="hasil_hpl" class="result-display rounded">
                    <h3 class="font-weight-bold mb-2">Hasil Perkiraan</h3>
                    <p class="mb-1"><strong>Hari Perkiraan Lahir (HPL): <span id="hpl_value" class="font-weight-bold"></span></strong></p>
                    <p class="mb-0"><strong>Perkiraan Usia Kehamilan Saat Ini: <span id="usia_kehamilan_value" class="font-weight-bold"></span></strong></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // --- Logika Kalkulator IMT ---
    $('#hitung_imt').on('click', function() {
        const tinggiCm = parseFloat($('#tinggi_badan').val());
        const berat = parseFloat($('#berat_badan').val());
        const hasilDiv = $('#hasil_imt');

        if (isNaN(tinggiCm) || isNaN(berat) || tinggiCm <= 0 || berat <= 0) {
            alert('Mohon masukkan tinggi dan berat badan yang valid.');
            return;
        }

        const tinggiM = tinggiCm / 100;
        const imt = (berat / (tinggiM * tinggiM)).toFixed(1);

        let kategori = '';
        let deskripsi = '';
        let kategoriClass = 'bmi-category-normal';

        if (imt < 18.5) {
            kategori = 'Berat Badan Kurang';
            deskripsi = 'Anda disarankan untuk meningkatkan asupan nutrisi untuk mencapai berat badan ideal.';
            kategoriClass = 'bmi-category-underweight';
        } else if (imt >= 18.5 && imt <= 22.9) {
            kategori = 'Berat Badan Normal';
            deskripsi = 'Selamat! Berat badan Anda ideal. Pertahankan pola hidup sehat.';
            kategoriClass = 'bmi-category-normal';
        } else if (imt >= 23 && imt <= 24.9) {
            kategori = 'Berat Badan Berlebih';
            deskripsi = 'Anda memiliki risiko ringan. Disarankan untuk mengatur pola makan dan meningkatkan aktivitas fisik.';
            kategoriClass = 'bmi-category-overweight';
        } else if (imt >= 25 && imt <= 29.9) {
            kategori = 'Obesitas Tingkat I';
            deskripsi = 'Anda memiliki risiko kesehatan. Sangat disarankan untuk berkonsultasi dengan tenaga kesehatan.';
            kategoriClass = 'bmi-category-obese';
        } else { // imt >= 30
            kategori = 'Obesitas Tingkat II';
            deskripsi = 'Anda memiliki risiko kesehatan yang tinggi. Segera konsultasikan dengan tenaga kesehatan.';
            kategoriClass = 'bmi-category-obese';
        }

        $('#imt_value').text(imt);
        $('#imt_category').text(kategori);
        $('#imt_description').text(deskripsi);

        hasilDiv.removeClass('bmi-category-underweight bmi-category-normal bmi-category-overweight bmi-category-obese').addClass(kategoriClass);
        hasilDiv.slideDown();
    });

    // --- Logika Kalkulator HPL ---
    $('#hitung_hpl').on('click', function() {
        const hphtVal = $('#hpht').val();
        if (!hphtVal) {
            alert('Mohon masukkan tanggal HPHT.');
            return;
        }

        const hphtDate = new Date(hphtVal);
        const today = new Date();

        // Hitung HPL menggunakan Aturan Naegele
        const hplDate = new Date(hphtDate);
        hplDate.setDate(hplDate.getDate() + 7);
        hplDate.setMonth(hplDate.getMonth() - 3);
        hplDate.setFullYear(hplDate.getFullYear() + 1);

        // Hitung Usia Kehamilan
        const diffTime = Math.abs(today - hphtDate);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        const weeks = Math.floor(diffDays / 7);
        const days = diffDays % 7;

        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };

        $('#hpl_value').text(hplDate.toLocaleDateString('id-ID', options));
        $('#usia_kehamilan_value').text(weeks + ' minggu ' + days + ' hari');
        $('#hasil_hpl').slideDown();
    });
});
</script>
@endpush
