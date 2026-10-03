<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Admin - Portal Banom NU</title>
    
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
            max-width: 420px;
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
        .form-control:focus {
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
        <p class="small mb-0 opacity-75">Login Khusus Administrator</p>
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

        <!-- FORM LOGIN ADMIN -->
        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="login_email" class="form-label small fw-semibold text-secondary">Email Administrator</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-secondary"><i class="fa-regular fa-envelope"></i></span>
                    <input type="email" class="form-control" id="login_email" name="email" value="{{ old('email') }}" placeholder="admin@banomnu.or.id" required autofocus>
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
                <i class="fa-solid fa-right-to-bracket me-1"></i> Masuk Administrator
            </button>
        </form>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>