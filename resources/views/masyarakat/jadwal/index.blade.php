@extends('layouts.app')

@push('styles')
{{-- Library untuk FullCalendar --}}
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
<style>
    /* Sedikit style tambahan agar kalender terlihat bagus */
    .fc-daygrid-day.fc-day-today {
        background-color: #eaf6ff !important; /* Warna biru muda untuk hari ini */
    }
    .fc-event {
        cursor: pointer;
        border: none !important;
        padding: 5px;
    }
    /* Style untuk daftar jadwal terdekat */
    .upcoming-events {
        max-height: 450px; /* Batasi tinggi agar bisa di-scroll */
        overflow-y: auto;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="row g-4">
        {{-- KOLOM KIRI: FILTER --}}
        <div class="col-lg-3">
            <div class="jadwal-filter p-4 rounded bg-white shadow-sm mb-4">
                <h5 class="mb-3">Cari Jadwal</h5>
                <div class="form-group mb-3">
                    <label for="desa_filter" class="form-label">Desa</label>
                    <select id="desa_filter" class="form-control">
                        <option value="">Semua Desa</option>
                        @foreach($desas as $desa)
                            <option value="{{ $desa->id }}">{{ $desa->nama_desa }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="dusun_filter" class="form-label">Dusun</label>
                    <select id="dusun_filter" class="form-control" disabled>
                        <option value="">Semua Dusun</option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="posyandu_filter" class="form-label">Posyandu</label>
                    <select id="posyandu_filter" class="form-control" disabled>
                        <option value="">Semua Posyandu</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- KOLOM TENGAH: JADWAL TERDEKAT --}}
        <div class="col-lg-4">
            <h5 class="mb-3">Jadwal Terdekat</h5>
            <div id="jadwal-list" class="upcoming-events">
                {{-- Daftar jadwal awal dimuat di sini --}}
                @include('masyarakat.jadwal._jadwal-list', ['jadwals' => $jadwals, 'confirmedIds' => $confirmedIds])
            </div>
        </div>

        {{-- KOLOM KANAN: KALENDER --}}
        <div class="col-lg-5">
            <h5 class="mb-3">Kalender</h5>
            {{-- Pastikan ID-nya 'calendar' --}}
            <div id="calendar" class="p-3 rounded bg-white shadow-sm"></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Library untuk FullCalendar & JQuery (jika belum ada di layout utama) --}}
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/id.js'></script> {{-- Bahasa Indonesia --}}

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'id',
        initialView: 'dayGridMonth',
        height: 'auto',
        headerToolbar: {
            left: 'prev',
            center: 'title',
            right: 'next'
        },
        events: function(fetchInfo, successCallback, failureCallback) {
            fetchAndRenderJadwal(fetchInfo.startStr, fetchInfo.endStr, successCallback, failureCallback);
        }
    });

    calendar.render();

    function fetchAndRenderJadwal(start = null, end = null, calendarCallback = null, failureCallback = null) {
        var desaId = $('#desa_filter').val();
        var dusunId = $('#dusun_filter').val();
        var posyanduId = $('#posyandu_filter').val();

        // Menggunakan rute yang benar untuk dashboard masyarakat
        var url = new URL('{{ route("masyarakat.jadwal.filter") }}');
        if (start) url.searchParams.append('start', start);
        if (end) url.searchParams.append('end', end);
        if (desaId) url.searchParams.append('desa_id', desaId);
        if (dusunId) url.searchParams.append('dusun_id', dusunId);
        if (posyanduId) url.searchParams.append('posyandu_id', posyanduId);

        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                $('#jadwal-list').html(response.list_html);
                if (calendarCallback) {
                    calendarCallback(response.events);
                }
            },
            error: function() {
                if (failureCallback) failureCallback();
                alert('Gagal memuat data jadwal.');
            }
        });
    }

    // Trigger reload saat filter berubah
    $('#desa_filter, #dusun_filter, #posyandu_filter').on('change', function() {
        calendar.refetchEvents(); // Ini akan otomatis memanggil fetchAndRenderJadwal
    });

    // Logika Dropdown Desa -> Dusun
    $('#desa_filter').on('change', function() {
        var desaId = $(this).val();
        var dusunSelect = $('#dusun_filter');
        var posyanduSelect = $('#posyandu_filter');

        dusunSelect.prop('disabled', true).empty().append('<option value="">Semua Dusun</option>');
        posyanduSelect.prop('disabled', true).empty().append('<option value="">Semua Posyandu</option>');

        if (desaId) {
            $.ajax({
                url: '{{ route("api.getDusuns") }}', // Menggunakan rute API publik
                type: 'POST',
                data: { _token: '{{ csrf_token() }}', desa_id: desaId },
                success: function(data) {
                    dusunSelect.prop('disabled', false);
                    $.each(data, function(key, value) {
                        dusunSelect.append('<option value="' + value.id + '">' + value.nama_dusun + '</option>');
                    });
                }
            });
        }
    });

    // Logika Dropdown Dusun -> Posyandu
    $('#dusun_filter').on('change', function() {
        var dusunId = $(this).val();
        var posyanduSelect = $('#posyandu_filter');

        posyanduSelect.prop('disabled', true).empty().append('<option value="">Semua Posyandu</option>');

        if (dusunId) {
            $.ajax({
                url: '{{ route("api.getPosyandus") }}', // Menggunakan rute API publik
                type: 'POST',
                data: { _token: '{{ csrf_token() }}', dusun_id: dusunId },
                success: function(data) {
                    posyanduSelect.prop('disabled', false);
                    $.each(data, function(key, value) {
                        posyanduSelect.append('<option value="' + value.id + '">' + value.nama_posyandu + '</option>');
                    });
                }
            });
        }
    });
});
</script>
@endpush
