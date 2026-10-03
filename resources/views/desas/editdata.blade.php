<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Anggota - Portal Organisasi NU</title>

    <!-- Bootstrap 5 CSS & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.net/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --green-nu: #007a3d;
            --green-dark: #00562b;
        }

        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        .bg-green-nu { background-color: var(--green-nu) !important; }
        .text-green-nu { color: var(--green-nu) !important; }
        
        .btn-green-nu {
            background-color: var(--green-nu);
            color: #fff;
        }
        .btn-green-nu:hover {
            background-color: var(--green-dark);
            color: #fff;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- NAVBAR -->
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
                        <a class="nav-link fw-semibold" href="{{ route('desas.index') }}">
                            <i class="fa-regular fa-newspaper me-1"></i> Berita & Kegiatan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="{{ route('desas.struktur') }}">
                            <i class="fa-solid fa-sitemap me-1"></i> Struktur Pengurus
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fw-semibold" href="{{ route('anggota.index') }}">
                            <i class="fa-solid fa-users me-1"></i> Data Anggota
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="container my-4 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold text-dark m-0">
                        <i class="fa-solid fa-user-pen text-green-nu me-2"></i>Edit Data Anggota
                    </h5>
                    <a href="{{ route('anggota.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>

                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-4">

                        <!-- Tampilkan Alert Validasi Error -->
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Form Edit Data (Menambahkan enctype multipart/form-data) -->
                        <form action="{{ route('anggota.update', $anggota->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Nama Anggota -->
                            <div class="mb-3">
                                <label for="nama" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $anggota->nama) }}" required placeholder="Masukkan nama lengkap">
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Jabatan -->
                            <div class="mb-3">
                                <label for="jabatan" class="form-label fw-semibold">Jabatan / Peran <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan" name="jabatan" value="{{ old('jabatan', $anggota->jabatan) }}" required placeholder="Contoh: Anggota, Ketua, Sekretaris">
                                @error('jabatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Upload & Preview Foto -->
                            <div class="mb-3">
                                <label for="foto" class="form-label fw-semibold">Foto Anggota</label>
                                
                                <!-- Container Preview Foto -->
                                <div class="mb-2 text-center">
                                    @if ($anggota->foto)
                                        <img id="imgPreview" src="{{ asset('storage/' . $anggota->foto) }}" alt="Foto Anggota" class="img-thumbnail rounded-circle shadow-sm" style="width: 120px; height: 120px; object-fit: cover;">
                                    @else
                                        <img id="imgPreview" src="https://via.placeholder.com/120?text=No+Image" alt="Preview Foto" class="img-thumbnail rounded-circle shadow-sm" style="width: 120px; height: 120px; object-fit: cover;">
                                    @endif
                                </div>

                                <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto" accept="image/*" onchange="previewImage(event)">
                                <small class="text-muted d-block mt-1">Biarkan kosong jika tidak ingin mengubah foto. (Format: JPG, JPEG, PNG, Maks: 2MB)</small>
                                
                                @error('foto')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Alamat -->
                            <div class="mb-3">
                                <label for="alamat" class="form-label fw-semibold">Alamat</label>
                                <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat">{{ old('alamat', $anggota->alamat) }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- No HP -->
                            <div class="mb-4">
                                <label for="nohp" class="form-label fw-semibold">No. WhatsApp / HP</label>
                                <input type="text" class="form-control @error('nohp') is-invalid @enderror" id="nohp" name="nohp" value="{{ old('nohp', $anggota->nohp) }}" placeholder="Contoh: 081234567890">
                                @error('nohp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tombol Submit -->
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-green-nu fw-bold py-2 rounded-pill">
                                    <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="bg-green-nu text-white py-4 mt-auto">
        <div class="container text-center">
            <small class="text-white-50">&copy; {{ date('Y') }} PR IPNU IPPNU, BANSER, MUSLIMAT & FATAYAT NU. All rights reserved.</small>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JS Live Preview Foto Baru -->
    <script>
        function previewImage(event) {
            const input = event.target;
            const imgPreview = document.getElementById('imgPreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imgPreview.src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>