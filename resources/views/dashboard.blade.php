@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin">
      <div class="row">
        <div class="col-12 col-xl-8 mb-4 mb-xl-0">
          {{-- Mengambil nama user yang sedang login --}}
          <h3 class="font-weight-bold">Selamat Datang, {{ Auth::user()->name }}!</h3>
          <h6 class="font-weight-normal mb-0">Semua sistem berjalan lancar! Anda memiliki <span class="text-primary">3 notifikasi baru!</span></h6>
        </div>
        <div class="col-12 col-xl-4">
         <div class="justify-content-end d-flex">
          <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
            <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
             <i class="mdi mdi-calendar"></i> Hari Ini (27 Jul 2025)
            </button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
              <a class="dropdown-item" href="#">Jan - Mar</a>
              <a class="dropdown-item" href="#">Mar - Jun</a>
              <a class="dropdown-item" href="#">Jun - Sep</a>
              <a class="dropdown-item" href="#">Sep - Dec</a>
            </div>
          </div>
         </div>
        </div>
      </div>
    </div>
</div>

{{-- Di sini kita bisa letakkan konten-konten dashboard lainnya nanti --}}
{{-- Misalnya kartu statistik, grafik, dll. --}}
{{-- Untuk sekarang kita biarkan minimalis dulu --}}

@endsection
