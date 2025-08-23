<div class="container-fluid bg-dark footer py-5">
    <div class="container py-5">
        <div class="pb-4 mb-4" style="border-bottom: 1px solid rgba(255, 255, 255, 0.08);">
            <div class="row g-4">
                <div class="col-lg-4">
                    <a href="{{ route('home') }}" class="d-flex align-items-center text-decoration-none">
                        @if(!empty($settings['logo_puskesmas']))
                            <img src="{{ asset('storage/' . $settings['logo_puskesmas']) }}" alt="Logo Puskesmas" style="height: 60px; margin-right: 15px;">
                        @endif
                        <div>
                            <p class="text-white mb-0 display-6">{{ $settings['nama_puskesmas'] ?? 'Puskesmas' }}</p>
                            <small class="text-light" style="letter-spacing: 2px; line-height: 2;">{{ $settings['kecamatan'] ?? 'Kecamatan' }}</small>
                        </div>
                    </a>
                </div>
                <div class="col-lg-8">
                    <div class="d-flex position-relative rounded-pill overflow-hidden">
                        <input class="form-control border-0 w-100 py-3 rounded-pill" type="email" placeholder="example@gmail.com">
                        <button type="submit" class="btn btn-primary border-0 py-3 px-5 rounded-pill text-white position-absolute" style="top: 0; right: 0;">Ikuti Kami</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-5">
            <div class="col-lg-6 col-xl-3">
                <div class="footer-item-1">
                    <h4 class="mb-4 text-white">Hubungi Kami</h4>
                    <p class="text-secondary line-h">Alamat: <span class="text-white">{{ $settings['alamat_lengkap'] ?? 'Alamat belum diisi' }}</span></p>
                    <p class="text-secondary line-h">Email: <span class="text-white">{{ $settings['email'] ?? 'Email belum diisi' }}</span></p>
                    <p class="text-secondary line-h">Telepon: <span class="text-white">{{ $settings['telepon'] ?? 'Telepon belum diisi' }}</span></p>
                    <div class="d-flex line-h">
                        <a class="btn btn-light me-2 btn-md-square rounded-circle" href="{{ $settings['sosmed_facebook'] ?? '#' }}"><i class="fab fa-facebook-f text-dark"></i></a>
                        <a class="btn btn-light me-2 btn-md-square rounded-circle" href="{{ $settings['sosmed_instagram'] ?? '#' }}"><i class="fab fa-instagram text-dark"></i></a>
                        <a class="btn btn-light me-2 btn-md-square rounded-circle" href="{{ $settings['sosmed_youtube'] ?? '#' }}"><i class="fab fa-youtube text-dark"></i></a>
                        <a class="btn btn-light btn-md-square rounded-circle" href="{{ $settings['sosmed_tiktok'] ?? '#' }}"><i class="fab fa-tiktok text-dark"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xl-3">
                <div class="d-flex flex-column text-start footer-item-3">
                    <h4 class="mb-4 text-white">Tautan Cepat</h4>
                    {{-- PERBAIKAN #1: Tampilkan menu dinamis dari Kluster --}}
                    <a class="btn-link text-white mb-2" href="{{ route('home') }}">Beranda</a>
                    <a class="btn-link text-white mb-2" href="{{ route('berita.semua') }}">Artikel</a>
                    @foreach($klusters as $kluster)
                        @php
                            $url = $kluster->url ?? ($kluster->halaman ? route('halaman.tampil', $kluster->halaman->slug) : '#');
                        @endphp
                        <a class="btn-link text-white mb-2" href="{{ $url }}">{{ $kluster->title }}</a>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-6 col-xl-3">
                <div class="footer-item-4">
                    <h4 class="mb-4 text-white">Galeri Terbaru</h4>
                    {{-- PERBAIKAN #2: Tampilkan 6 foto terbaru dari Galeri --}}
                    <div class="row g-2">
                        @forelse($footerGaleris as $galeri)
                        <div class="col-4">
                            <div class="rounded overflow-hidden">
                                <img src="{{ asset('storage/' . $galeri->path_gambar) }}" class="img-zoomin img-fluid rounded w-100" alt="{{ $galeri->judul }}">
                            </div>
                        </div>
                        @empty
                        <p class="text-secondary">Belum ada foto di galeri.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Copyright Start -->
<div class="container-fluid copyright bg-dark py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                <span class="text-light"><a href="#"><i class="fas fa-copyright text-light me-2"></i>Puskesmas Panjalu</a>, All right reserved.</span>
            </div>
        </div>
    </div>
</div>
<!-- Copyright End -->
