<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struktur Pengurus - Portal Organisasi NU</title>

    <!-- Bootstrap 5 CSS & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.net/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --green-nu: #007a3d;
            --green-hover: #005a2d;
            --yellow-accent: #fbc02d;
        }

        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        .bg-green-nu { background-color: var(--green-nu) !important; }
        .text-green-nu { color: var(--green-nu) !important; }

        /* Nav Pills / Tab Scrollable */
        .scrolling-tabs-wrapper {
            overflow-x: auto;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
            padding-bottom: 5px;
        }
        .scrolling-tabs-wrapper::-webkit-scrollbar {
            display: none;
        }

        .nav-pills .nav-link {
            color: var(--green-nu);
            border: 1px solid var(--green-nu);
            border-radius: 50rem;
            padding: 0.5rem 1.25rem;
            font-weight: 600;
            transition: all 0.2s ease-in-out;
        }

        .nav-pills .nav-link.active {
            background-color: var(--green-nu);
            color: #fff;
            box-shadow: 0 4px 10px rgba(0, 122, 61, 0.25);
        }

        /* Avatar Pengurus */
        .avatar-pengurus {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid var(--green-nu);
        }

        .section-title {
            border-left: 4px solid var(--green-nu);
            padding-left: 0.75rem;
            font-weight: 700;
        }

        .card-pengurus {
            border: 1px solid #e9ecef;
            border-radius: 12px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card-pengurus:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.06);
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- 1. NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-green-nu sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="{{ route('desas.index') }}">
                <img src="{{ asset('images/ipnu_ippnu.png') }}" onerror="this.src='https://via.placeholder.com/40'" alt="Logo NU" class="bg-white rounded-circle p-1" style="height: 36px;">
                <span class="fs-6 fs-md-5">PORTAL BANOM NU</span>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse mt-3 mt-lg-0" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('desas.index') }}">Berita & Kegiatan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('desas.struktur') }}">Struktur Pengurus</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('anggota.index') }}">Data Anggota</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-2">
                    @auth
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-sm fw-semibold">
                                <i class="fa-solid fa-right-from-bracket me-1"></i> Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-light btn-sm fw-bold text-success">
                            <i class="fa-solid fa-right-to-bracket me-1"></i> Masuk / Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- 2. KONTEN UTAMA -->
    <main class="container my-4 mb-5">

        <!-- Header Halaman -->
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2 mb-4">
            <div>
                <h4 class="fw-bold text-dark m-0">
                    <i class="fa-solid fa-sitemap text-green-nu me-2"></i>Struktur Kepengurusan
                </h4>
                <p class="text-muted small m-0 mt-1">Daftar struktur organisasi Badan Otonom Nahdlatul Ulama</p>
            </div>
            <a href="{{ route('desas.index') }}" class="btn btn-outline-success btn-sm rounded-pill fw-semibold">
                <i class="fa-regular fa-newspaper me-1"></i> Lihat Berita
            </a>
        </div>

        <!-- Tab Navigasi Banom -->
        <div class="scrolling-tabs-wrapper mb-4">
            <ul class="nav nav-pills flex-nowrap justify-content-start justify-content-md-center gap-2" id="pengurusTab" role="tablist">
                @foreach ($banomList as $key => $info)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $loop->first ? 'active' : '' }}" 
                                id="{{ $key }}-tab" 
                                data-bs-toggle="tab" 
                                data-bs-target="#tab-{{ $key }}" 
                                type="button" 
                                role="tab">
                            {{ $info['title'] }}
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Isi Konten Tab Pengurus -->
        <div class="tab-content" id="pengurusTabContent">
            @foreach ($banomList as $key => $info)
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="tab-{{ $key }}" role="tabpanel">
                    
                    <div class="bg-white p-3 p-md-4 rounded-3 shadow-sm">
                        <h5 class="section-title text-dark mb-4">Struktur Pengurus {{ $info['title'] }}</h5>
                        
                        <div class="row g-3 g-md-4 text-center">
                            @foreach ($info['pengurus'] as $p)
                                <div class="col-12 col-sm-6 col-md-4">
                                    <div class="p-4 card-pengurus bg-light h-100 d-flex flex-column align-items-center justify-content-center">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($p['nama']) }}&background=007a3d&color=fff" 
                                             class="avatar-pengurus mb-3 shadow-sm" 
                                             alt="{{ $p['nama'] }}">
                                        <h6 class="fw-bold text-dark mb-1 fs-6">{{ $p['nama'] }}</h6>
                                        <span class="badge bg-success-subtle text-green-nu border border-success-subtle fw-bold px-3 py-1 mt-1">
                                            {{ $p['jabatan'] }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

    </main>

    <!-- 3. FOOTER -->
    <footer class="bg-green-nu text-white py-3 mt-auto text-center">
        <div class="container">
            <small>&copy; {{ date('Y') }} PR IPNU IPPNU, Banser, Muslimat & Fatayat NU. All rights reserved.</small>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>