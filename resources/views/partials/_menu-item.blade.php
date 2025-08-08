@if ($menu->childrenRecursive->isNotEmpty())
    {{-- Jika ini adalah level pertama --}}
    @if (!isset($isChild))
        <div class="nav-item dropdown position-static">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">{{ $menu->title }}</a>
            <div class="dropdown-menu m-0 bg-light rounded-0">
                @foreach ($menu->childrenRecursive as $child)
                    @include('layouts.partials._menu-item', ['menu' => $child, 'isChild' => true])
                @endforeach
            </div>
        </div>
    @else
        {{-- Jika ini adalah submenu --}}
        <a href="#" class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown">{{ $menu->title }}</a>
        <div class="dropdown-menu dropdown-submenu m-0 bg-light rounded-0">
            @foreach ($menu->childrenRecursive as $child)
                @include('layouts.partials._menu-item', ['menu' => $child, 'isChild' => true])
            @endforeach
        </div>
    @endif
@else
    @php
        $menuUrl = '#';
        if ($menu->url) {
            $menuUrl = $menu->url;
        } elseif ($menu->halaman) {
            // Ganti di sini untuk menggunakan nama rute yang BARU
            $menuUrl = route('halaman.tampil', $menu->halaman);
        }
    @endphp

    @if (!isset($isChild))
        {{-- Menu utama tanpa anak --}}
        <a href="{{ $menuUrl }}" class="nav-item nav-link">{{ $menu->title }}</a>
    @else
        {{-- Submenu (dropdown-item) --}}
        <a href="{{ $menuUrl }}" class="dropdown-item">{{ $menu->title }}</a>
    @endif
@endif
