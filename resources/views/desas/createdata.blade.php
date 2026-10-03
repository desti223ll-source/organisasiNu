<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.net/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light py-5">
<div class="container" style="max-width: 600px;">
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-success text-white py-3">
            <h5 class="mb-0 fw-bold"><i class="fa-solid fa-user-plus me-2"></i>Tambah Data Anggota</h5>
        </div>
        <div class="card-body p-4">

            <!-- Menampilkan Notifikasi Jika Ada Error Validasi -->
            @if ($errors->any())
                <div class="alert alert-danger mb-3">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Wajib menambahkan enctype="multipart/form-data" untuk upload file -->
            <form action="{{ route('anggota.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" placeholder="Masukkan nama..." required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Jabatan</label>
                    <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan') }}" placeholder="Contoh: Ketua, Sekretaris, Anggota" required>
                </div>

                <!-- Input Foto Anggota -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Foto Anggota</label>
                    <input type="file" name="foto" id="fotoInput" class="form-control" accept="image/*" onchange="previewImage(event)">
                    <small class="text-muted">Format: JPG, JPEG, PNG (Maks. 2MB)</small>
                    
                    <!-- Preview Foto -->
                    <div class="mt-2 text-center d-none" id="previewContainer">
                        <img id="imgPreview" src="#" alt="Preview Foto" class="img-thumbnail rounded-circle shadow-sm" style="width: 120px; height: 120px; object-fit: cover;">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat..." required>{{ old('alamat') }}</textarea>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">No HP / WhatsApp</label>
                    <input type="text" name="nohp" class="form-control" value="{{ old('nohp') }}" placeholder="08123456789" required>
                </div>
                
                <div class="d-flex justify-content-between pt-2">
                    <a href="{{ route('anggota.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-success"><i class="fa-solid fa-save me-1"></i> Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Fungsi untuk menampilkan preview foto yang dipilih
    function previewImage(event) {
        const input = event.target;
        const previewContainer = document.getElementById('previewContainer');
        const imgPreview = document.getElementById('imgPreview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                imgPreview.src = e.target.result;
                previewContainer.classList.remove('d-none');
            }
            
            reader.readAsDataURL(input.files[0]);
        } else {
            previewContainer.classList.add('d-none');
        }
    }
</script>
</body>
</html>