{{-- File: resources/views/partials/_galeri-layout.blade.php --}}
@if($items->isNotEmpty())
<div class="row">
    <div class="col-md-8 mb-4">
        <div class="position-relative">
            <a href="{{ asset('storage/' . $items->first()->path_gambar) }}" data-lightbox="galeri-{{ $id }}" data-title="{{ $items->first()->judul }}">
                <img id="mainImage-{{ $id }}" src="{{ asset('storage/' . $items->first()->path_gambar) }}" class="img-fluid rounded w-100 galeri-main-img" alt="{{ $items->first()->judul }}">
            </a>
            <div id="caption-{{ $id }}" class="caption-overlay p-3 text-white">
                {{ $items->first()->judul }}
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="thumbnail-container d-flex flex-md-column flex-row overflow-auto gap-3">
            @foreach($items as $item)
                <div class="thumb-item" style="cursor: pointer;" onclick="changeMainImage('{{ $id }}', '{{ asset('storage/' . $item->path_gambar) }}', '{{ $item->judul }}', '{{ asset('storage/' . $item->path_gambar) }}')">
                    <img src="{{ asset('storage/' . $item->path_gambar) }}" class="img-fluid rounded" alt="{{ $item->judul }}">
                </div>
            @endforeach
        </div>
    </div>
</div>
@else
<div class="alert alert-secondary text-center">
    Tidak ada foto dalam kategori ini.
</div>
@endif
