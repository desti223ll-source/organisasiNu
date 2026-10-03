<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Berita - IPNU IPPNU</title>
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
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .bg-green-nu {
            background-color: var(--green-nu) !important;
        }
        .btn-green {
            background-color: var(--green-nu);
            color: #fff;
            font-weight: 600;
        }
        .btn-green:hover {
            background-color: var(--green-hover);
            color: #fff;
        }
        .logo-navbar {
            height: 38px;
            width: auto;
        }
        .card-form {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--green-nu);
            box-shadow: 0 0 0 0.25rem rgba(0, 122, 61, 0.25);
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-green-nu sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('desas.index') }}">
            <img src="{{ asset('images/ipnu_ippnu.png') }}" onerror="this.src='https://via.placeholder.com/40'" alt="Logo IPNU IPPNU" class="logo-navbar bg-white rounded-circle p-1">
            <span>IPNU IPPNU DESA</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto ms-lg-3">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('desas.index') }}">Beranda</a>
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
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- FORM KONTEN UTAMA -->
<main class="container my-5 flex-grow-1" style="max-width: 800px;">
    
    <!-- Tombol Kembali -->
    <div class="mb-3">
        <a href="{{ route('desas.index') }}" class="text-decoration-none text-secondary fw-semibold">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Beranda
        </a>
    </div>

    <div class="card card-form bg-white">
        <div class="card-header bg-white pt-4 px-4 pb-0 border-0">
            <h4 class="fw-bold text-dark border-start border-4 border-success ps-3 mb-0">Tambah Berita & Kegiatan Baru</h4>
            <p class="text-secondary small mt-1 ps-3 mb-0">Isi formulir di bawah ini untuk mempublikasikan berita terbaru.</p>
        </div>

        <div class="card-body p-4">

            <!-- Alert Peringatan Validasi Error -->
            @if ($errors->any())
                <div class="alert alert-danger py-2 small mb-4">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- PERHATIKAN: Ditambahkan enctype="multipart/form-data" -->
            <form action="{{ route('desas.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Input Judul Berita -->
                <div class="mb-3">
                    <label for="judulberita" class="form-label fw-semibold text-dark">Judul Berita / Kegiatan</label>
                    <input type="text" class="form-control" id="judulberita" name="judulberita" value="{{ old('judulberita') }}" placeholder="Contoh: Rapat Anggota & Makesta Ranting Desa" required>
                </div>

                <!-- Input Kategori -->
                <div class="mb-3">
                    <label for="kategori" class="form-label fw-semibold text-dark">Kategori Berita</label>
                    <select class="form-select" id="kategori" name="kategori" required>
                        <option value="ipnu" {{ old('kategori', $kategori ?? '') == 'ipnu' ? 'selected' : '' }}>IPNU / IPPNU</option>
                        <option value="banser" {{ old('kategori', $kategori ?? '') == 'banser' ? 'selected' : '' }}>BANSER</option>
                        <option value="muslimat" {{ old('kategori', $kategori ?? '') == 'muslimat' ? 'selected' : '' }}>MUSLIMAT</option>
                        <option value="fatayat" {{ old('kategori', $kategori ?? '') == 'fatayat' ? 'selected' : '' }}>FATAYAT</option>
                    </select>
                </div>

                <!-- Input Tanggal -->
                <div class="mb-3">
                    <label for="tanggal" class="form-label fw-semibold text-dark">Tanggal Pelaksanaan / Rilis</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                </div>

                <!-- Input Gambar Berita (BARU) -->
                <div class="mb-3">
                    <label for="gambar" class="form-label fw-semibold text-dark">Foto Berita / Dokumentasi</label>
                    <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                    <small class="text-muted">Format yang didukung: JPG, JPEG, PNG, WEBP (Maksimal 2MB).</small>
                </div>

                <!-- Input Isi Berita -->
                <div class="mb-4">
                    <label for="isiberita" class="form-label fw-semibold text-dark">Isi Berita Lengkap</label>
                    <textarea class="form-control" id="isiberita" name="isiberita" rows="6" placeholder="Tuliskan detail kegiatan atau berita di sini..." required>{{ old('isiberita') }}</textarea>
                </div>

                <!-- Tombol Aksi -->
                <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                    <a href="{{ route('desas.index') }}" class="btn btn-light fw-semibold">Batal</a>
                    <button type="submit" class="btn btn-green px-4">
                        <i class="fa-solid fa-paper-plane me-1"></i> Terbitkan Berita
                    </button>
                </div>

            </form>
        </div>
    </div>
</main>

<!-- FOOTER -->
<footer class="bg-green-nu text-white py-4 mt-auto">
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
        <div class="d-flex align-items-center gap-2">
            <img src="{{ asset('images/ipnu_ippnu.png') }}" onerror="this.src='https://via.placeholder.com/30'" alt="Logo IPNU IPPNU" style="height: 30px;">
            <span class="small">&copy; {{ date('Y') }} PR IPNU IPPNU Desa. All Rights Reserved.</span>
        </div>
        <div>
            <a href="#" class="text-white me-3"><i class="fa-brands fa-instagram fa-lg"></i></a>
            <a href="#" class="text-white me-3"><i class="fa-brands fa-facebook fa-lg"></i></a>
            <a href="#" class="text-white"><i class="fa-brands fa-youtube fa-lg"></i></a>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>