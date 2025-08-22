<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>SIMPUS - Dashboard</title>

  <link rel="stylesheet" href="{{ asset('vendors/feather/feather.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/ti-icons/css/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.base.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('js/select.dataTables.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/vertical-layout-light/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/vertical-layout-light/fitur.css') }}">
  <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" alt='icon' />
  <link rel="stylesheet" href="{{ asset('vendors/mdi/css/materialdesignicons.min.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
  <div class="container-scroller">
    @include('layouts.partials.header')
    {{-- REVISI: Menghapus include right-sidebar yang duplikat dengan setting --}}
    <div class="container-fluid page-body-wrapper">
      @include('layouts.partials.setting')
      @include('layouts.partials.right-sidebar')
      @include('layouts.partials.sidebar')
      <div class="main-panel">
        <div class="content-wrapper">
          @yield('content')
        </div>
        @include('layouts.partials.footer')
      </div>
    </div>
  </div>
    <script src="{{ asset('vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('js/off-canvas.js') }}"></script>
    <script src="{{ asset('js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>
    <script src="{{ asset('js/settings.js') }}"></script>
    <script src="{{ asset('js/todolist.js') }}"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="{{ asset('js/Chart.roundedBarCharts.js') }}"></script>
    <script src="{{ asset('js/file-upload.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

    <script>
        $(document).ready(function() {
            // 2. "KABEL" UNIVERSAL UNTUK MODAL HAPUS
            // Script ini akan mengawasi SELURUH halaman untuk klik pada tombol '.delete-btn'
            $(document).on('click', '.delete-btn', function() {
                // Ambil URL dari atribut data-url tombol yang baru saja diklik
                var deleteUrl = $(this).data('url');

                // Atur 'action' dari form di dalam modal menjadi URL tersebut
                $('#deleteForm').attr('action', deleteUrl);
            });
        })
    </script>


    {{--
        REVISI UTAMA: Menambahkan @yield('scripts')
        Ini adalah "placeholder" untuk menampung semua script tambahan
        dari halaman lain, seperti script modal hapus dari index.blade.php.
    --}}
    @stack('scripts')
    @yield('scripts')

  </body>

</html>
