{{-- File: resources/views/kluster/partials/_row.blade.php --}}

<tr>
    {{-- Kolom Judul dengan indentasi/spasi --}}
    <td style="padding-left: {{ $level * 25 }}px;">
        @if($level > 0)
            <i class="mdi mdi-subdirectory-arrow-right"></i>
        @endif
        {{ $kluster->title }}
    </td>

    {{-- Kolom Halaman Terhubung --}}
    <td>
        @if($kluster->halaman)
            <span class="badge badge-info">{{ $kluster->halaman->judul }}</span>
        @elseif($kluster->url)
             <span class="badge badge-primary">Link Manual</span>
        @else
            <span class="badge badge-secondary">-</span>
        @endif
    </td>

    {{-- Kolom Urutan --}}
    <td>{{ $kluster->order }}</td>

    {{-- Kolom Aksi --}}
    <td class="d-flex">
        <a href="{{ route('kluster.edit', $kluster->id) }}" class="btn btn-warning btn-sm mr-2">Edit</a>
        <form action="{{ route('kluster.destroy', $kluster->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin?')">
                Hapus
            </button>
        </form>
    </td>
</tr>

{{-- Jika kluster ini punya anak, panggil lagi template ini untuk setiap anak --}}
@if ($kluster->childrenRecursive->isNotEmpty())
    @foreach ($kluster->childrenRecursive as $child)
        @include('kluster.partials._row', ['kluster' => $child, 'level' => $level + 1])
    @endforeach
@endif
