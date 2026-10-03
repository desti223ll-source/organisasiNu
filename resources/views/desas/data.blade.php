<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Anggota - Portal Organisasi NU</title>
    
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
        
        .section-title { 
            border-left: 4px solid var(--green-nu); 
            padding-left: 0.75rem; 
            font-weight: 700; 
        }

        /* Desain Kartu Tanda Anggota (KTA) - Solid Color */
        .kta-card {
            width: 100%;
            max-width: 400px;
            height: 240px;
            background-color: #007a3d;
            color: #ffffff;
            border-radius: 14px;
            padding: 18px;
            position: relative;
            box-shadow: 0 8px 18px rgba(0,0,0,0.15);
            overflow: hidden;
            margin: 0 auto;
        }

        .kta-header {
            border-bottom: 2px solid var(--yellow-accent);
            padding-bottom: 6px;
            margin-bottom: 12px;
        }

        .kta-avatar {
            width: 65px;
            height: 65px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--yellow-accent);
            background-color: #fff;
            flex-shrink: 0;
        }

        .kta-label {
            font-size: 0.65rem;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.8);
            letter-spacing: 0.5px;
        }

        .kta-value {
            font-size: 0.88rem;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 2px;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- 1. NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-green-nu sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="{{ route('desas.index') }}">
                <img src="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23007a3d'><circle cx='12' cy='12' r='10' fill='%23ffffff'/><path d='M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z'/></svg>" class="kta-avatar shadow-sm" alt="Logo" style="width: 40px; height: 40px;">
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
                            <i class="fa-solid fa-right-to-bracket me-1"></i> Masuk Admin
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- 2. MAIN CONTENT -->
    <main class="container my-4">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
            <div class="card-header bg-white py-3 d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
                <div>
                    <h5 class="fw-bold mb-0 text-dark section-title">
                        Direktori Data Anggota
                    </h5>
                    <small class="text-muted">Daftar Keanggotaan Badan Otonom NU</small>
                </div>
                
                <div class="d-flex gap-2">
                    <a href="{{ route('desas.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill fw-semibold px-3">
                        <i class="fa-solid fa-arrow-left me-1"></i> Beranda
                    </a>
                    
                    @auth
                        <a href="{{ route('anggota.create') }}" class="btn btn-success btn-sm rounded-pill fw-semibold px-3 shadow-sm">
                            <i class="fa-solid fa-user-plus me-1"></i> Tambah Anggota
                        </a>
                    @endauth
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0">
                        <thead class="bg-green-nu text-white">
                            <tr>
                                <th class="py-3 px-4" style="width: 60px;">No</th>
                                <th class="py-3 px-4">Foto</th>
                                <th class="py-3 px-4">Nama</th>
                                <th class="py-3 px-4">Jabatan</th>
                                <th class="py-3 px-4">Alamat</th>
                                <th class="py-3 px-4">No HP</th>
                                <th class="py-3 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($anggota as $key => $item)
                                @php
                                    $defaultAvatar = "data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23007a3d'><circle cx='12' cy='12' r='10' fill='%23e0e0e0'/><path d='M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z'/></svg>";
                                    $fotoUrl = $item->gambar ? asset('storage/' . $item->gambar) : $defaultAvatar;
                                @endphp
                                <tr>
                                    <td class="px-4 fw-bold text-secondary">{{ $key + 1 }}</td>
                                    <td class="px-4">
                                        <img src="{{ $fotoUrl }}" onerror="this.src='{{ $defaultAvatar }}'" class="rounded-circle border" style="width: 40px; height: 40px; object-fit: cover;" alt="Foto {{ $item->nama }}">
                                    </td>
                                    <td class="px-4 fw-semibold">{{ $item->nama }}</td>
                                    <td class="px-4">
                                        <span class="badge bg-success-subtle text-green-nu border border-success-subtle fw-semibold px-2 py-1">
                                            {{ $item->jabatan }}
                                        </span>
                                    </td>
                                    <td class="px-4 text-secondary small">{{ $item->alamat }}</td>
                                    <td class="px-4 text-secondary small">{{ $item->nohp }}</td>
                                    <td class="px-4 text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <!-- Tombol Kartu -->
                                            <button type="button" 
                                                    class="btn btn-primary btn-sm text-white btn-open-kta" 
                                                    title="Lihat & Download Kartu"
                                                    data-nama="{{ $item->nama }}"
                                                    data-jabatan="{{ $item->jabatan }}"
                                                    data-alamat="{{ $item->alamat }}"
                                                    data-nohp="{{ $item->nohp }}"
                                                    data-foto="{{ $fotoUrl }}">
                                                <i class="fa-solid fa-id-card me-1"></i> Kartu
                                            </button>

                                            <!-- Tombol Detail (Diubah Menjadi Modal Trigger) -->
                                            <button type="button" 
                                                    class="btn btn-info btn-sm text-white btn-open-detail" 
                                                    title="Lihat Detail"
                                                    data-nama="{{ $item->nama }}"
                                                    data-jabatan="{{ $item->jabatan }}"
                                                    data-alamat="{{ $item->alamat }}"
                                                    data-nohp="{{ $item->nohp }}"
                                                    data-foto="{{ $fotoUrl }}">
                                                <i class="fa-solid fa-eye me-1"></i> Detail
                                            </button>

                                            @auth
                                                <a href="{{ route('anggota.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Edit Data">
                                                    <i class="fa-solid fa-pen me-1"></i> Edit
                                                </a>
                                                <form action="{{ route('anggota.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus Data">
                                                        <i class="fa-solid fa-trash me-1"></i> Hapus
                                                    </button>
                                                </form>
                                            @endauth
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-users-slash fa-2x mb-2 d-block"></i>
                                        Belum ada data anggota tersimpan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- MODAL PRATINJAU KARTU ANGGOTA -->
    <div class="modal fade" id="ktaModal" tabindex="-1" aria-labelledby="ktaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-0 pb-0">
                    <h6 class="modal-title fw-bold" id="ktaModalLabel">
                        <i class="fa-solid fa-id-card text-green-nu me-2"></i>Kartu Tanda Anggota (KTA)
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4">
                    
                    <div id="ktaCardToRender" class="kta-card text-start">
                        <div class="kta-header d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ asset('images/ipnu_ippnu.png') }}" onerror="this.onerror=null; this.src='data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22%23ffffff%22><circle cx=%2212%22 cy=%2212%22 r=%2210%22/></svg>'" alt="Logo NU" style="height: 30px; width: 30px;" crossorigin="anonymous">
                                <div>
                                    <div class="fw-bold" style="font-size: 0.72rem; letter-spacing: 0.5px; line-height: 1.1;">KARTU TANDA ANGGOTA</div>
                                    <div style="font-size: 0.58rem; color: var(--yellow-accent);" class="fw-semibold">PORTAL BANOM NU</div>
                                </div>
                            </div>
                            <i class="fa-solid fa-star-and-crescent fa-lg text-warning"></i>
                        </div>

                        <div class="d-flex align-items-center gap-3 mt-2">
                            <img id="ktaFoto" src="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23007a3d'><circle cx='12' cy='12' r='10' fill='%23e0e0e0'/><path d='M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z'/></svg>" class="kta-avatar shadow-sm" alt="Foto Anggota">
                            <div class="flex-grow-1 overflow-hidden">
                                <div class="kta-label">Nama Anggota</div>
                                <div id="ktaNama" class="kta-value text-truncate">Nama Lengkap</div>

                                <div class="kta-label">Jabatan</div>
                                <div id="ktaJabatan" class="kta-value text-truncate">Jabatan</div>
                            </div>
                        </div>

                        <div class="row g-1 mt-2 pt-2 border-top border-white-50">
                            <div class="col-7">
                                <div class="kta-label">Alamat</div>
                                <div id="ktaAlamat" class="kta-value small text-truncate" style="font-size: 0.72rem;">Alamat</div>
                            </div>
                            <div class="col-5">
                                <div class="kta-label">No. Telepon</div>
                                <div id="ktaNohp" class="kta-value small text-truncate" style="font-size: 0.72rem;">No HP</div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer border-0 pt-0 justify-content-center pb-4">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-semibold" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" id="btnDownload" class="btn btn-success rounded-pill px-4 fw-semibold shadow-sm" onclick="downloadKtaCard()">
                        <i class="fa-solid fa-download me-1"></i> Download Gambar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DETAIL ANGGOTA -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-0 bg-green-nu text-white rounded-top-4">
                    <h6 class="modal-title fw-bold" id="detailModalLabel">
                        <i class="fa-solid fa-circle-info me-2"></i>Detail Anggota
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <div class="text-center mb-4">
                        <img id="detailFoto" src="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23007a3d'><circle cx='12' cy='12' r='10' fill='%23e0e0e0'/><path d='M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z'/></svg>" class="rounded-circle border border-3 border-success shadow-sm mb-3" style="width: 100px; height: 100px; object-fit: cover;" alt="Foto Anggota">
                        <h5 id="detailNama" class="fw-bold mb-1 text-dark">-</h5>
                        <span id="detailJabatan" class="badge bg-success-subtle text-green-nu border border-success-subtle fw-semibold px-3 py-2 rounded-pill">-</span>
                    </div>
                    <div class="list-group list-group-flush border-top">
                        <div class="list-group-item d-flex align-items-center py-3 bg-transparent">
                            <i class="fa-solid fa-location-dot text-green-nu fa-lg me-3" style="width: 20px;"></i>
                            <div>
                                <small class="text-muted d-block">Alamat Lengkap</small>
                                <span id="detailAlamat" class="fw-semibold text-dark">-</span>
                            </div>
                        </div>
                        <div class="list-group-item d-flex align-items-center py-3 bg-transparent">
                            <i class="fa-solid fa-phone text-green-nu fa-lg me-3" style="width: 20px;"></i>
                            <div>
                                <small class="text-muted d-block">Nomor HP / WhatsApp</small>
                                <span id="detailNohp" class="fw-semibold text-dark">-</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 justify-content-center pb-4">
                    <button type="button" class="btn btn-secondary rounded-pill px-4 fw-semibold" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

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

    <!-- JS DEPENDENCIES -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

    <script>
        let currentAnggotaNama = 'Anggota';
        const defaultAvatar = "data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23007a3d'><circle cx='12' cy='12' r='10' fill='%23e0e0e0'/><path d='M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z'/></svg>";

        document.addEventListener('DOMContentLoaded', function () {
            // Event listener untuk tombol .btn-open-kta
            const ktaButtons = document.querySelectorAll('.btn-open-kta');
            const ktaModalEl = document.getElementById('ktaModal');
            const ktaModal = new bootstrap.Modal(ktaModalEl);

            ktaButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const nama = this.getAttribute('data-nama');
                    const jabatan = this.getAttribute('data-jabatan');
                    const alamat = this.getAttribute('data-alamat');
                    const nohp = this.getAttribute('data-nohp');
                    const foto = this.getAttribute('data-foto');

                    currentAnggotaNama = nama;

                    document.getElementById('ktaNama').innerText = nama || '-';
                    document.getElementById('ktaJabatan').innerText = jabatan || '-';
                    document.getElementById('ktaAlamat').innerText = alamat || '-';
                    document.getElementById('ktaNohp').innerText = nohp || '-';

                    const imgKta = document.getElementById('ktaFoto');
                    imgKta.src = foto || defaultAvatar;
                    imgKta.onerror = function() {
                        this.src = defaultAvatar;
                    };

                    ktaModal.show();
                });
            });

            // Event listener untuk tombol .btn-open-detail
            const detailButtons = document.querySelectorAll('.btn-open-detail');
            const detailModalEl = document.getElementById('detailModal');
            const detailModal = new bootstrap.Modal(detailModalEl);

            detailButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const nama = this.getAttribute('data-nama');
                    const jabatan = this.getAttribute('data-jabatan');
                    const alamat = this.getAttribute('data-alamat');
                    const nohp = this.getAttribute('data-nohp');
                    const foto = this.getAttribute('data-foto');

                    document.getElementById('detailNama').innerText = nama || '-';
                    document.getElementById('detailJabatan').innerText = jabatan || '-';
                    document.getElementById('detailAlamat').innerText = alamat || '-';
                    document.getElementById('detailNohp').innerText = nohp || '-';

                    const imgDetail = document.getElementById('detailFoto');
                    imgDetail.src = foto || defaultAvatar;
                    imgDetail.onerror = function() {
                        this.src = defaultAvatar;
                    };

                    detailModal.show();
                });
            });
        });

        function downloadKtaCard() {
            if (typeof html2canvas !== 'function') {
                alert("Library html2canvas belum siap. Silakan refresh halaman.");
                return;
            }

            const ktaElement = document.getElementById('ktaCardToRender');
            const btnDownload = document.getElementById('btnDownload');
            
            const originalText = btnDownload.innerHTML;
            btnDownload.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Memproses...';
            btnDownload.disabled = true;

            html2canvas(ktaElement, {
                scale: 3,
                useCORS: true,
                allowTaint: false,
                backgroundColor: "#007a3d"
            }).then(canvas => {
                const imageData = canvas.toDataURL('image/png');
                const link = document.createElement('a');
                const cleanName = currentAnggotaNama.toLowerCase().replace(/[^a-z0-9]/g, '_');
                link.download = `KTA_NU_${cleanName}.png`;
                link.href = imageData;
                
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);

                btnDownload.innerHTML = originalText;
                btnDownload.disabled = false;
            }).catch(err => {
                console.error(err);
                alert("Gagal mengunduh kartu.");
                btnDownload.innerHTML = originalText;
                btnDownload.disabled = false;
            });
        }
    </script>
</body>
</html>