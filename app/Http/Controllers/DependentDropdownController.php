<?php

namespace App\Http\Controllers;

use App\Models\Dusun;
use App\Models\Posyandu;
use Illuminate\Http\Request;

class DependentDropdownController extends Controller
{
    /**
     * Mengambil data Dusun berdasarkan desa_id yang dikirim via POST request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDusuns(Request $request)
    {
        // 1. Validasi untuk memastikan desa_id ada di dalam request
        $request->validate(['desa_id' => 'required|exists:desas,id']);

        // 2. Cari semua dusun yang memiliki desa_id yang sesuai
        $dusuns = Dusun::where('desa_id', $request->desa_id)->get();

        // 3. Kembalikan data dalam format JSON
        return response()->json($dusuns);
    }

    /**
     * Mengambil data Posyandu berdasarkan dusun_id yang dikirim via POST request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPosyandus(Request $request)
    {
        // 1. Validasi untuk memastikan dusun_id ada di dalam request
        $request->validate(['dusun_id' => 'required|exists:dusuns,id']);

        // 2. Cari semua posyandu yang memiliki dusun_id yang sesuai
        $posyandus = Posyandu::where('dusun_id', $request->dusun_id)->get();

        // 3. Kembalikan data dalam format JSON
        return response()->json($posyandus);
    }
}
