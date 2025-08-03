@extends('layouts.frontend')

@section('content')

<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="border-bottom mb-4">
                    <h1 class="display-4 mb-4">{{ $halaman->judul }}</h1>
                </div>
                <div class="isi-halaman">
                    {!! $halaman->isi !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
