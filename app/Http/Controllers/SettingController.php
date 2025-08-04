<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Menampilkan halaman form pengaturan profil puskesmas.
     */
    public function index()
    {
        // Ambil semua data settings dan ubah menjadi format yang mudah diakses di view
        // Contoh: $settings['nama_puskesmas'] akan berisi nilainya.
        $settings = Setting::pluck('value', 'key');

        return view('settings.index', compact('settings'));
    }

    /**
     * Memperbarui data pengaturan di database.
     */
    public function update(Request $request)
    {
        // Loop melalui setiap data yang dikirim dari form
        foreach ($request->except('_token') as $key => $value) {

            // Cek jika ada file yang diupload (untuk logo dan foto)
            if ($request->hasFile($key)) {
                // Hapus file lama jika ada
                $oldFile = Setting::where('key', $key)->first()->value;
                if ($oldFile) {
                    Storage::disk('public')->delete($oldFile);
                }

                // Upload file baru dan simpan path-nya
                $path = $request->file($key)->store('settings', 'public');
                Setting::where('key', $key)->update(['value' => $path]);

            } else {
                // Jika bukan file, langsung update nilainya
                Setting::where('key', $key)->update(['value' => $value]);
            }
        }

        return redirect()->back()
                         ->with('success', 'Profil Puskesmas berhasil diperbarui.');
    }
}
