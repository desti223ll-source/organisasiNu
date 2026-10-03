<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Berita - Portal Organisasi NU</title>
    
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

        .card-form {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--green-nu);
            box-shadow: 0 0 0 0.25rem rgba(0, 122, 61, 0.15);
        }

        .img-preview {
            max-height: 200px;
            width: 100%;
            object-fit: cover;
            border-radius: 10px;
        }

        .section-title-edit {
            border-left: 4px solid var(--yellow-accent);
            padding-left: 0.75rem;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

<!-- 1. NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-green-nu sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('desas.index') }}">
            <img src="{{ asset('images/ipnu_ippnu.png') }}" onerror="this.src='https://placehold.co/40x40?text=NU'" alt="Logo NU" class="bg-white rounded-circle p-1" style="height: 36px;">
            <span class="fs-6 fs-md-5">PORTAL BANOM NU</span>
        </a>
        
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse mt-2 mt-lg-0" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('desas.index') }}">Beranda</a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-2">
                @auth
                    <form action="{{ route('logout') }}" method="POST" class="d-inline w-100">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm fw-semibold w-100">
                            <i class="fa-solid fa-right-from-bracket me-1"></i> Logout
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- 2. MAIN CONTENT -->
<main class="container my-4 my-md-5 flex-grow-1" style="max-width: 850px;">
    
    <!-- Navigation Back Button -->
    <div class="mb-3">
        <a href="{{ route('desas.index') }}" class="btn btn-link text-decoration-none text-secondary p-0 fw-semibold">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Beranda
        </a>
    </div>

    <!-- Form Card -->
    <div class="card card-form bg-white">
        <div class="card-header bg-white pt-4 px-3 px-md-4 pb-2 border-0">
            <div class="section-title-edit">
                <h4 class="fw-bold text-dark m-0">Edit Berita & Kegiatan</h4>
                <p class="text-muted small mt-1 mb-0">Perbarui informasi warta berita atau kegiatan organisasi.</p>
            </div>
        </div>

        <div class="card-body p-3 p-md-4">

            <form action="{{ route('desas.update', $desa->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Judul Berita -->
                <div class="mb-3">
                    <label for="judulberita" class="form-label fw-semibold text-dark">
                        <i class="fa-solid fa-heading me-1 text-green-nu"></i> Judul Berita / Kegiatan
                    </label>
                    <input type="text" class="form-control @error('judulberita') is-invalid @enderror" id="judulberita" name="judulberita" value="{{ old('judulberita', $desa->judulberita) }}" placeholder="Masukkan judul berita..." required>
                    @error('judulberita')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Grid Kategori & Tanggal (Responsif 2 Kolom) -->
                <div class="row g-3 mb-3">
                    <div class="col-12 col-md-6">
                        <label for="kategori" class="form-label fw-semibold text-dark">
                            <i class="fa-solid fa-layer-group me-1 text-green-nu"></i> Kategori Banom
                        </label>
                        <select class="form-select @error('kategori') is-invalid @enderror" id="kategori" name="kategori" required>
                            <option value="ipnu" {{ old('kategori', $desa->kategori) == 'ipnu' ? 'selected' : '' }}>IPNU & IPPNU</option>
                            <option value="banser" {{ old('kategori', $desa->kategori) == 'banser' ? 'selected' : '' }}>BANSER</option>
                            <option value="muslimat" {{ old('kategori', $desa->kategori) == 'muslimat' ? 'selected' : '' }}>MUSLIMAT NU</option>
                            <option value="fatayat" {{ old('kategori', $desa->kategori) == 'fatayat' ? 'selected' : '' }}>FATAYAT NU</option>
                        </select>
                        @error('kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="tanggal" class="form-label fw-semibold text-dark">
                            <i class="fa-regular fa-calendar-days me-1 text-green-nu"></i> Tanggal Kegiatan / Rilis
                        </label>
                        <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ old('tanggal', $desa->tanggal) }}" required>
                        @error('tanggal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Gambar & Preview Live -->
                <div class="mb-3">
                    <label for="gambar" class="form-label fw-semibold text-dark">
                        <i class="fa-regular fa-image me-1 text-green-nu"></i> Foto Dokumentasi
                    </label>
                    
                    <div class="row g-3 align-items-center mb-2">
                        <!-- Preview Box -->
                        <div class="col-12 col-sm-5 col-md-4">
                            <div class="border rounded-3 p-2 bg-light text-center">
                                @if ($desa->gambar)
                                    <img id="preview-img" src="{{ asset('storage/' . $desa->gambar) }}" alt="Preview Gambar" class="img-preview border shadow-sm">
                                @else
                                    <img id="preview-img" src="https://placehold.co/300x160?text=Tidak+Ada+Gambar" alt="Preview Gambar" class="img-preview border shadow-sm">
                                @endif
                                <small class="text-muted d-block mt-1 fs-xs">Pratinjau Foto</small>
                            </div>
                        </div>
                        
                        <!-- Upload Input Box -->
                        <div class="col-12 col-sm-7 col-md-8">
                            <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar" name="gambar" accept="image/*" onchange="previewImage(event)">
                            <small class="text-muted d-block mt-2">
                                Biarkan kosong jika tidak ingin mengganti gambar.<br>
                                <strong>Format:</strong> JPG, JPEG, PNG, WEBP (Maks. 2MB).
                            </small>
                            @error('gambar')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Isi Berita -->
                <div class="mb-4">
                    <label for="isiberita" class="form-label fw-semibold text-dark">
                        <i class="fa-solid fa-align-left me-1 text-green-nu"></i> Isi Berita Lengkap
                    </label>
                    <textarea class="form-control @error('isiberita') is-invalid @enderror" id="isiberita" name="isiberita" rows="7" placeholder="Tuliskan detail berita atau laporan kegiatan..." required>{{ old('isiberita', $desa->isiberita) }}</textarea>
                    @error('isiberita')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="d-flex flex-column flex-sm-row justify-content-end gap-2 pt-3 border-top">
                    <a href="{{ route('desas.index') }}" class="btn btn-light fw-semibold order-2 order-sm-1">Batal</a>
                    <button type="submit" class="btn btn-warning fw-bold px-4 order-1 order-sm-2">
                        <i class="fa-solid fa-rotate me-1"></i> Perbarui Berita
                    </button>
                </div>

            </form>
        </div>
    </div>
</main>

<!-- 3. FOOTER -->
<footer class="bg-green-nu text-white py-4 mt-auto">
    <div class="container d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3 text-center text-sm-start">
        <div class="d-flex align-items-center gap-2">
            <img src="{{ asset('images/ipnu_ippnu.png') }}" onerror="this.src='https://placehold.co/30x30?text=NU'" alt="Logo NU" style="height: 30px;">
            <span class="small">&copy; {{ date('Y') }} PR IPNU IPPNU, Banser, Muslimat & Fatayat NU. All rights reserved.</span>
        </div>
        <div class="d-flex gap-3">
            <a href="#" class="text-white text-decoration-none"><i class="fa-brands fa-instagram fa-lg"></i></a>
            <a href="#" class="text-white text-decoration-none"><i class="fa-brands fa-facebook fa-lg"></i></a>
            <a href="#" class="text-white text-decoration-none"><i class="fa-brands fa-youtube fa-lg"></i></a>
        </div>
    </div>
</footer>

<!-- JS Script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-img').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
</script>
</body>
</html>