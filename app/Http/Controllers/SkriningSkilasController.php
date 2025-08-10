<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SkriningSkilas;
use Illuminate\Support\Facades\Auth;

class SkriningSkilasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data skrining, sertakan data user yang menginput
        // Urutkan dari yang paling baru
        $skriningSkilas = SkriningSkilas::with('user')->latest()->get();

        // Kirim data ke view
        return view('skrining-skilas.index', compact('skriningSkilas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Cukup tampilkan view-nya
        return view('skrining-skilas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi semua input dari form
        $validatedData = $request->validate([
            'tanggal_skrining' => 'required|date',
            'nik' => 'required|string|size:16|unique:skrining_skilas,nik',
            'nama_lengkap' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_hp' => 'nullable|string|max:15',
            'alamat' => 'required|string',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
            'kelurahan' => 'required|string|max:255',
            // Riwayat Penyakit (boolean)
            'riwayat_ginjal' => 'sometimes|boolean',
            'riwayat_penglihatan' => 'sometimes|boolean',
            'riwayat_pendengaran' => 'sometimes|boolean',
            // Konsumsi Makanan (boolean)
            'konsumsi_pokok' => 'sometimes|boolean',
            'konsumsi_lauk' => 'sometimes|boolean',
            'konsumsi_sayur' => 'sometimes|boolean',
            'konsumsi_buah' => 'sometimes|boolean',
            // Pemeriksaan Fisik (numeric)
            'td_sistolik' => 'nullable|integer',
            'td_diastolik' => 'nullable|integer',
            'berat_badan' => 'nullable|numeric',
            'tinggi_badan' => 'nullable|numeric',
            'imt' => 'nullable|numeric',
            'lila' => 'nullable|numeric',
            // Laboratorium (numeric)
            'gds' => 'nullable|integer',
            'kolesterol' => 'nullable|integer',
            'asam_urat' => 'nullable|numeric',
            'hb' => 'nullable|numeric',
            // Skrining SKILAS (boolean)
            'skilas_kognitif_tanggal_salah' => 'sometimes|boolean',
            'skilas_kognitif_lokasi_salah' => 'sometimes|boolean',
            'skilas_kognitif_kata_salah' => 'sometimes|boolean',
            'skilas_mobilitas_terbatas' => 'sometimes|boolean',
            'skilas_malnutrisi_bb_turun' => 'sometimes|boolean',
            'skilas_malnutrisi_nafsu_makan' => 'sometimes|boolean',
            'skilas_malnutrisi_lila_rendah' => 'sometimes|boolean',
            'skilas_penglihatan_buram' => 'sometimes|boolean',
            'skilas_penglihatan_tes_jari' => 'sometimes|boolean',
            'skilas_pendengaran_terganggu' => 'sometimes|boolean',
            'skilas_depresi_sedih' => 'sometimes|boolean',
            'skilas_depresi_kurang_semangat' => 'sometimes|boolean',
            // Tindak Lanjut
            'tindak_lanjut_rujukan' => 'sometimes|boolean',
            'tujuan_rujukan' => 'nullable|string|max:255',
            'alasan_rujukan' => 'nullable|string',
            // TAMBAHKAN VALIDASI INI
            'adl_bab' => 'nullable|integer',
            'adl_bak' => 'nullable|integer',
            'adl_membersihkan_diri' => 'nullable|integer',
            'adl_wc' => 'nullable|integer',
            'adl_makan_minum' => 'nullable|integer',
            'adl_berbaring_duduk' => 'nullable|integer',
            'adl_berjalan' => 'nullable|integer',
            'adl_berpakaian' => 'nullable|integer',
            'adl_naik_tangga' => 'nullable|integer',
            'adl_mandi' => 'nullable|integer',
        ]);

        // Menambahkan user_id dari user yang sedang login
        $validatedData['user_id'] = Auth::id();

        // Mengubah checkbox yang tidak dicentang menjadi nilai 0 (false)
        $checkboxes = [
            'riwayat_ginjal', 'riwayat_penglihatan', 'riwayat_pendengaran',
            'konsumsi_pokok', 'konsumsi_lauk', 'konsumsi_sayur', 'konsumsi_buah',
            'skilas_kognitif_tanggal_salah', 'skilas_kognitif_lokasi_salah', 'skilas_kognitif_kata_salah',
            'skilas_mobilitas_terbatas', 'skilas_malnutrisi_bb_turun', 'skilas_malnutrisi_nafsu_makan',
            'skilas_malnutrisi_lila_rendah', 'skilas_penglihatan_buram', 'skilas_penglihatan_tes_jari',
            'skilas_pendengaran_terganggu', 'skilas_depresi_sedih', 'skilas_depresi_kurang_semangat',
            'tindak_lanjut_rujukan'
        ];

        foreach ($checkboxes as $checkbox) {
            if (!isset($validatedData[$checkbox])) {
                $validatedData[$checkbox] = 0;
            }
        }

        SkriningSkilas::create($validatedData);

        return redirect()->route('admin.skrining-skilas.index')
                         ->with('success', 'Data skrining baru berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SkriningSkilas $skriningSkila)
    {
        // Laravel sudah otomatis mencari data berdasarkan ID yang dikirim.
        // Kita hanya perlu mengirimnya ke view.
        return view('skrining-skilas.show', ['skrining' => $skriningSkila]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SkriningSkilas $skriningSkila) // Laravel akan otomatis mencari data berdasarkan ID
    {
        return view('skrining-skilas.edit', ['skrining' => $skriningSkila]);
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(Request $request, SkriningSkilas $skriningSkila)
    {
        // Validasi, pastikan NIK unik tapi abaikan NIK dari data yang sedang diedit
        $validatedData = $request->validate([
            'tanggal_skrining' => 'required|date',
            'nik' => 'required|string|size:16|unique:skrining_skilas,nik,' . $skriningSkila->id,
            'nama_lengkap' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_hp' => 'nullable|string|max:15',
            'alamat' => 'required|string',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
            'kelurahan' => 'required|string|max:255',
            // ... (tambahkan semua validasi lain dari fungsi store di sini)
        ]);

        // Mengubah checkbox yang tidak dicentang menjadi nilai 0 (false)
        $checkboxes = [
            'riwayat_ginjal', 'riwayat_penglihatan', 'riwayat_pendengaran',
            'konsumsi_pokok', 'konsumsi_lauk', 'konsumsi_sayur', 'konsumsi_buah',
            'skilas_kognitif_tanggal_salah', 'skilas_kognitif_lokasi_salah', 'skilas_kognitif_kata_salah',
            'skilas_mobilitas_terbatas', 'skilas_malnutrisi_bb_turun', 'skilas_malnutrisi_nafsu_makan',
            'skilas_malnutrisi_lila_rendah', 'skilas_penglihatan_buram', 'skilas_penglihatan_tes_jari',
            'skilas_pendengaran_terganggu', 'skilas_depresi_sedih', 'skilas_depresi_kurang_semangat',
            'tindak_lanjut_rujukan'
        ];

        foreach ($checkboxes as $checkbox) {
            if (!isset($validatedData[$checkbox])) {
                $validatedData[$checkbox] = 0;
            } else {
                $validatedData[$checkbox] = 1;
            }
        }

        $skriningSkila->update($validatedData);

        return redirect()->route('admin.skrining-skilas.index')
                         ->with('success', 'Data skrining berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SkriningSkilas $skriningSkila)
    {
        $skriningSkila->delete();
        return redirect()->route('admin.skrining-skilas.index')
                         ->with('success', 'Data skrining berhasil dihapus.');
    }
}
