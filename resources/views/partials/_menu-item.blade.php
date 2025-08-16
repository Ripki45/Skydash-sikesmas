{{-- _menu-item.blade.php --}}

@if ($menu->childrenRecursive->isNotEmpty())
    @if (!isset($isChild))
        {{-- Menu level pertama dengan anak --}}
        <li class="nav-item dropdown position-static">
            <a href="#" class="nav-link dropdown-toggle fw-bold" data-bs-toggle="dropdown">
                {{ $menu->title }}
            </a>
            <div class="dropdown-menu m-0 bg-light rounded-0 shadow border-0">
                @foreach ($menu->childrenRecursive as $child)
                    @include('layouts.partials._menu-item', [
                        'menu' => $child,
                        'isChild' => true
                    ])
                @endforeach
            </div>
        </li>
    @else
        {{-- Submenu --}}
        <div class="dropdown-submenu">
            <a href="#" class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown">
                {{ $menu->title }}
            </a>
            <div class="dropdown-menu m-0 bg-light rounded-0 shadow border-0">
                @foreach ($menu->childrenRecursive as $child)
                    @include('layouts.partials._menu-item', [
                        'menu' => $child,
                        'isChild' => true
                    ])
                @endforeach
            </div>
        </div>
    @endif
@else
    @php
        $menuUrl = '#';
        if (!empty($menu->url)) {
            $menuUrl = $menu->url;
        } elseif (!empty($menu->halaman)) {
            $menuUrl = route('halaman.tampil', $menu->halaman->slug);
        }
    @endphp

    @if (!isset($isChild))
        {{-- Menu utama tanpa anak --}}
        <li class="nav-item">
            <a href="{{ $menuUrl }}" class="nav-link fw-bold">{{ $menu->title }}</a>
        </li>
    @else
        {{-- Submenu item --}}
        <a href="{{ $menuUrl }}" class="dropdown-item">{{ $menu->title }}</a>
    @endif
@endif
