<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Akun - Portal Banom NU</title>
    
    <!-- Bootstrap 5 CSS & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.net/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background-color: #f4f7f6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card-auth {
            width: 100%;
            max-width: 460px;
            border: none;
            border-radius: 14px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
        .card-header-green {
            background-color: #007a3d;
            color: #ffffff;
            padding: 24px 20px;
            text-align: center;
        }
        .nav-tabs .nav-link {
            color: #555;
            font-weight: 600;
            border: none;
            border-bottom: 3px solid transparent;
        }
        .nav-tabs .nav-link.active {
            color: #007a3d;
            border-bottom: 3px solid #007a3d;
            font-weight: 700;
            background: transparent;
        }
        .btn-green {
            background-color: #007a3d;
            color: #ffffff;
            border: none;
            font-weight: 600;
            padding: 10px;
            transition: background 0.2s;
        }
        .btn-green:hover {
            background-color: #005a2d;
            color: #ffffff;
        }
        .form-control:focus, .form-select:focus {
            border-color: #007a3d;
            box-shadow: 0 0 0 0.25rem rgba(0, 122, 61, 0.2);
        }
    </style>
</head>
<body>

<div class="card card-auth bg-white my-4">
    <div class="card-header-green">
        <img src="https://upload.wikimedia.org/wikipedia/commons/e/e1/Lambang_Nahdlatul_Ulama.svg" alt="Logo NU" style="height: 48px;" class="mb-2 bg-white rounded-circle p-1">
        <h5 class="fw-bold mb-0">PORTAL BANOM NU</h5>
        <p class="small mb-0 opacity-75">Sistem Informasi & Keanggotaan</p>
    </div>

    <div class="card-body p-4">

        {{-- Flash Message Error / Success --}}
        @if (session('error'))
            <div class="alert alert-danger py-2 small mb-3 rounded-3">
                <i class="fa-solid fa-circle-exclamation me-1"></i> {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success py-2 small mb-3 rounded-3">
                <i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger py-2 small mb-3 rounded-3">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Tab Navigasi Masuk / Daftar -->
        <ul class="nav nav-tabs nav-fill mb-4" id="authTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ session('tab') == 'register' ? '' : 'active' }}" id="login-tab" data-bs-toggle="tab" data-bs-target="#login-pane" type="button" role="tab">
                    <i class="fa-solid fa-right-to-bracket me-1"></i> Masuk
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ session('tab') == 'register' ? 'active' : '' }}" id="register-tab" data-bs-toggle="tab" data-bs-target="#register-pane" type="button" role="tab">
                    <i class="fa-solid fa-user-plus me-1"></i> Daftar
                </button>
            </li>
        </ul>

        <!-- Tab Contents -->
        <div class="tab-content" id="authTabContent">
            
            <!-- 1. FORM LOGIN -->
            <div class="tab-pane fade {{ session('tab') == 'register' ? '' : 'show active' }}" id="login-pane" role="tabpanel">
                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="login_email" class="form-label small fw-semibold text-secondary">Alamat Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-secondary"><i class="fa-regular fa-envelope"></i></span>
                            <input type="email" class="form-control" id="login_email" name="email" value="{{ old('email') }}" placeholder="contoh@gmail.com" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="login_password" class="form-label small fw-semibold text-secondary">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-secondary"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" class="form-control" id="login_password" name="password" placeholder="••••••••" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-green w-100 rounded-3 fw-bold">
                        Masuk ke Portal
                    </button>
                </form>
            </div>

            <!-- 2. FORM REGISTRASI -->
            <div class="tab-pane fade {{ session('tab') == 'register' ? 'show active' : '' }}" id="register-pane" role="tabpanel">
                <form action="{{ route('register.post') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="reg_name" class="form-label small fw-semibold text-secondary">Nama Lengkap</label>
                        <input type="text" class="form-control" id="reg_name" name="name" value="{{ old('name') }}" placeholder="Sesuai KTP / KTA" required>
                    </div>

                    <div class="mb-3">
                        <label for="reg_banom" class="form-label small fw-semibold text-secondary">Badan Otonom (Banom)</label>
                        <select class="form-select" id="reg_banom" name="banom" required>
                            <option value="" disabled selected>-- Pilih Banom --</option>
                            <option value="ipnu" {{ old('banom') == 'ipnu' ? 'selected' : '' }}>IPNU</option>
                            <option value="banser" {{ old('banom') == 'banser' ? 'selected' : '' }}>BANSER</option>
                            <option value="muslimat" {{ old('banom') == 'muslimat' ? 'selected' : '' }}>Muslimat NU</option>
                            <option value="fatayat" {{ old('banom') == 'fatayat' ? 'selected' : '' }}>Fatayat NU</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="reg_email" class="form-label small fw-semibold text-secondary">Alamat Email</label>
                        <input type="email" class="form-control" id="reg_email" name="email" value="{{ old('email') }}" placeholder="email@gmail.com" required>
                    </div>

                    <div class="mb-3">
                        <label for="reg_password" class="form-label small fw-semibold text-secondary">Password</label>
                        <input type="password" class="form-control" id="reg_password" name="password" placeholder="Minimal 6 karakter" required>
                    </div>

                    <div class="mb-4">
                        <label for="reg_password_confirmation" class="form-label small fw-semibold text-secondary">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="reg_password_confirmation" name="password_confirmation" placeholder="Ulangi password" required>
                    </div>

                    <button type="submit" class="btn btn-green w-100 rounded-3 fw-bold">
                        Daftar Akun Baru
                    </button>
                </form>
            </div>

        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>