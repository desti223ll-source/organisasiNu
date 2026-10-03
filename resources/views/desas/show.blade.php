@php
    use Illuminate\Support\Facades\Storage;
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $berita->judulberita ?? 'Detail Berita' }} - Portal Banom NU</title>
    
    <!-- Bootstrap 5 CSS & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.net/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root { 
            --green-nu: #007a3d; 
            --green-dark: #00562b;
            --yellow-accent: #fbc02d; 
        }
        
        body { 
            background-color: #f4f6f9; 
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif; 
        }

        .bg-green-nu { background-color: var(--green-nu) !important; }
        .text-green-nu { color: var(--green-nu) !important; }
        
        .img-detail { 
            max-height: 480px; 
            object-fit: cover; 
            width: 100%; 
            border-radius: 12px; 
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- 1. NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-green-nu sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="{{ route('desas.index') }}">
                <img src="{{ asset('images/ipnu_ippnu.png') }}" onerror="this.src='https://via.placeholder.com/40'" alt="Logo NU" class="bg-white rounded-circle p-1" style="height: 38px; width: 38px;">
                <span>PORTAL BANOM NU</span>
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active fw-semibold" href="{{ route('desas.index') }}">
                            <i class="fa-regular fa-newspaper me-1"></i> Berita & Kegiatan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="{{ route('desas.struktur') }}">
                            <i class="fa-solid fa-sitemap me-1"></i> Struktur Pengurus
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="{{ route('anggota.index') }}">
                            <i class="fa-solid fa-users me-1"></i> Data Anggota
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-2 mt-2 mt-lg-0">
                    @auth
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-sm fw-semibold rounded-pill px-3">
                                <i class="fa-solid fa-right-from-bracket me-1"></i> Keluar
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-warning btn-sm fw-bold rounded-pill px-3 text-dark">
                            <i class="fa-solid fa-right-to-bracket me-1"></i> Masuk
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- 2. MAIN CONTENT -->
    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                
                <!-- Tombol Kembali -->
                <div class="mb-3">
                    <a href="{{ route('desas.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Beranda
                    </a>
                </div>

                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
                    
                    <!-- Kategori & Tanggal -->
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="badge bg-success text-uppercase px-3 py-2 rounded-pill fw-semibold">
                            {{ $berita->kategori ?? 'Umum' }}
                        </span>
                        <span class="text-muted small">
                            <i class="fa-regular fa-calendar-days me-1 text-green-nu"></i>
                            {{ !empty($berita->tanggal) ? \Carbon\Carbon::parse($berita->tanggal)->translatedFormat('d F Y') : '-' }}
                        </span>
                    </div>

                    <!-- Judul Berita -->
                    <h2 class="fw-bold text-dark mb-4">{{ $berita->judulberita }}</h2>

                    <!-- Gambar Berita (Logika Urutan Diperbaiki) -->
                    <div class="mb-4">
                        @if (!empty($berita->gambar) && (str_starts_with($berita->gambar, 'http://') || str_starts_with($berita->gambar, 'https://')))
                            <img src="{{ $berita->gambar }}" class="img-detail shadow-sm" alt="{{ $berita->judulberita }}">
                        @elseif (!empty($berita->gambar) && Storage::disk('public')->exists($berita->gambar))
                            <img src="{{ Storage::url($berita->gambar) }}" class="img-detail shadow-sm" alt="{{ $berita->judulberita }}">
                        @else
                            <img src="https://via.placeholder.com/800x450?text=Warta+NU" class="img-detail shadow-sm" alt="Placeholder">
                        @endif
                    </div>

                    <!-- Isi Berita -->
                    <div class="lh-lg text-secondary fs-6">
                        {!! nl2br(e($berita->isiberita)) !!}
                    </div>

                    <!-- Tombol Aksi Admin -->
                    @auth
                        <div class="d-flex gap-2 mt-5 pt-3 border-top">
                            <a href="{{ route('desas.edit', $berita->id) }}" class="btn btn-warning rounded-pill px-4 fw-semibold text-dark">
                                <i class="fa-solid fa-pen me-1"></i> Edit Berita
                            </a>
                        </div>
                    @endauth

                </div>
            </div>
        </div>
    </main>

    <!-- 3. FOOTER -->
    <footer class="bg-green-nu text-white py-4 mt-auto">
        <div class="container">
            <div class="row g-3 align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <h6 class="fw-bold mb-1">PORTAL INFORMASI BANOM NU</h6>
                    <small class="text-white-50">Menjalin Ukhuwah, Mengabdi untuk Ummat.</small>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <small class="text-white-50">&copy; {{ date('Y') }} PR IPNU IPPNU, BANSER, MUSLIMAT & FATAYAT NU. All rights reserved.</small>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>