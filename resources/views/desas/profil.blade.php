<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Anggota - Portal Banom NU</title>
    
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
        .card-form {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }
        .btn-green-nu {
            background-color: var(--green-nu);
            color: #fff;
            border: none;
        }
        .btn-green-nu:hover {
            background-color: var(--green-dark);
            color: #fff;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- NAVBAR -->
    <nav class="navbar navbar-dark bg-green-nu shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="{{ route('desas.index') }}">
                <img src="https://upload.wikimedia.org/wikipedia/commons/e/e1/Lambang_Nahdlatul_Ulama.svg" 
                     alt="Logo NU" style="height: 38px;" class="bg-white rounded-circle p-1">
                <span>PORTAL BANOM NU</span>
            </a>
            <a href="{{ route('anggota.index') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">
                <i class="fa-solid fa-users me-1"></i> Lihat Data Anggota
            </a>
        </div>
    </nav>

    <!-- KONTEN UTAMA -->
    <main class="container my-auto py-3">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                
                <div class="card card-form bg-white p-4">
                    <div class="text-center mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-light text-green-nu rounded-circle mb-2" style="width: 60px; height: 60px;">
                            <i class="fa-solid fa-user-plus fa-2x"></i>
                        </div>
                        <h4 class="fw-bold text-dark m-0">Form Profil & Data Anggota Baru</h4>
                        <p class="text-muted small">Isi data di bawah ini untuk menambahkan anggota ke sistem.</p>
                    </div>

                    {{-- Menampilkan Pesan Error Validasi --}}
                    @if ($errors->any())
                        <div class="alert alert-danger rounded-3 mb-4">
                            <ul class="mb-0 small ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Form Tambah Data Anggota --}}
                    <form action="{{ route('register.post') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Nama Lengkap -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold small text-muted">Nama Lengkap <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fa-solid fa-user text-muted"></i></span>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
                            </div>
                        </div>

                        <!-- Alamat Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold small text-muted">Alamat Email <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fa-solid fa-envelope text-muted"></i></span>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="contoh@gmail.com" required>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold small text-muted">Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fa-solid fa-key text-muted"></i></span>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Minimal 6 karakter" required>
                            </div>
                        </div>

                        <!-- Pilihan Banom -->
                        <div class="mb-3">
                            <label for="banom" class="form-label fw-semibold small text-muted">Badan Otonom (Banom) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fa-solid fa-users text-muted"></i></span>
                                <select class="form-select" id="banom" name="banom" required>
                                    <option value="" selected disabled>-- Pilih Banom --</option>
                                    <option value="IPNU" {{ old('banom') == 'IPNU' ? 'selected' : '' }}>IPNU</option>
                                    <option value="IPPNU" {{ old('banom') == 'IPPNU' ? 'selected' : '' }}>IPPNU</option>
                                    <option value="BANSER" {{ old('banom') == 'BANSER' ? 'selected' : '' }}>BANSER</option>
                                    <option value="Muslimat NU" {{ old('banom') == 'Muslimat NU' ? 'selected' : '' }}>Muslimat NU</option>
                                    <option value="Fatayat NU" {{ old('banom') == 'Fatayat NU' ? 'selected' : '' }}>Fatayat NU</option>
                                </select>
                            </div>
                        </div>

                        <!-- Pilihan Role -->
                        <div class="mb-3">
                            <label for="role" class="form-label fw-semibold small text-muted">Peran / Role <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fa-solid fa-shield-halved text-muted"></i></span>
                                <select class="form-select" id="role" name="role" required>
                                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Anggota (User)</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                                </select>
                            </div>
                        </div>

                        <!-- Upload Foto Profil (Opsional) -->
                        <div class="mb-4">
                            <label for="foto" class="form-label fw-semibold small text-muted">Foto Profil (Opsional)</label>
                            <input class="form-control" type="file" id="foto" name="foto" accept="image/*">
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-green-nu py-2 fw-bold rounded-pill shadow-sm">
                                <i class="fa-solid fa-paper-plane me-1"></i> Simpan Data Anggota
                            </button>
                            <a href="{{ route('desas.index') }}" class="btn btn-light py-2 text-muted fw-semibold rounded-pill">
                                Batal
                            </a>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="bg-white border-top py-3 mt-auto text-center text-muted small">
        &copy; {{ date('Y') }} Portal Informasi Banom NU. All rights reserved.
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>