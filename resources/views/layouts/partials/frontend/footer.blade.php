        <div class="container-fluid bg-dark footer py-5">
            <div class="container py-5">
                <div class="pb-4 mb-4" style="border-bottom: 1px solid rgba(255, 255, 255, 0.08);">
                    <div class="row g-4">
                        <div class="col-lg-4">
                            {{-- REVISI: Menggunakan data dinamis untuk logo dan nama --}}
                            <a href="{{ route('home') }}" class="d-flex align-items-center text-decoration-none">
                                {{-- Tampilkan logo jika ada --}}
                                @if(!empty($settings['logo_puskesmas']))
                                    <img src="{{ asset('storage/' . $settings['logo_puskesmas']) }}" alt="Logo Puskesmas" style="height: 60px; margin-right: 15px;">
                                @endif

                                <div>
                                    {{-- Tampilkan nama puskesmas dan kecamatan --}}
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
                            <p class="text-secondary line-h">Telepon: <span class="text-white">{{ $settings['telepon'] ?? 'Telepon belum diisi' }}</p>
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
                            <h4 class="mb-4 text-white">Kembali Ke Atas</h4>
                            <a class="btn-link text-white"href="{{ route('home') }}" class="nav-item nav-link fw-bold {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
                            <a class="btn-link text-white"href="{{ route('berita.semua') }}" class="nav-item nav-link fw-bold {{ request()->routeIs('berita.semua') ? 'active' : '' }}">Artikel</a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-3">
                        <div class="footer-item-4">
                            <h4 class="mb-4 text-white">Our Gallary</h4>
                            <div class="row g-2">
                                <div class="col-4">
                                    <div class="rounded overflow-hidden">
                                        <img src="{{ asset('frontend/img/footer-1.jpg') }}" class="img-zoomin img-fluid rounded w-100" alt="">
                                    </div>
                               </div>
                               <div class="col-4">
                                    <div class="rounded overflow-hidden">
                                        <img src="{{ asset('frontend/img/footer-2.jpg') }}" class="img-zoomin img-fluid rounded w-100" alt="">
                                    </div>
                               </div>
                                <div class="col-4">
                                    <div class="rounded overflow-hidden">
                                        <img src="{{ asset('frontend/img/footer-3.jpg') }}" class="img-zoomin img-fluid rounded w-100" alt="">
                                    </div>
                               </div>
                                <div class="col-4">
                                    <div class="rounded overflow-hidden">
                                        <img src="{{ asset('frontend/img/footer-4.jpg') }}" class="img-zoomin img-fluid rounded w-100" alt="">
                                    </div>
                               </div>
                                <div class="col-4">
                                    <div class="rounded overflow-hidden">
                                        <img src="{{ asset('frontend/img/footer-5.jpg') }}" class="img-zoomin img-fluid rounded w-100" alt="">
                                    </div>
                               </div>
                               <div class="col-4">
                                <div class="rounded overflow-hidden">
                                    <img src="{{ asset('frontend/img/footer-6.jpg') }}" class="img-zoomin img-fluid rounded w-100" alt="">
                                </div>
                           </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->


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
