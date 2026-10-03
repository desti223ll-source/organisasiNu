<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DesaController extends Controller
{
    /**
     * Tampilkan Halaman Berita & Kegiatan (Index)
     */
    public function index()
    {
        $allBerita = Desa::latest()->get();

        $desa = [
            'ipnu'     => $allBerita->filter(fn($item) => str_contains(strtolower($item->kategori ?? ''), 'ipnu')),
            'banser'   => $allBerita->filter(fn($item) => str_contains(strtolower($item->kategori ?? ''), 'banser')),
            'muslimat' => $allBerita->filter(fn($item) => str_contains(strtolower($item->kategori ?? ''), 'muslimat')),
            'fatayat'  => $allBerita->filter(fn($item) => str_contains(strtolower($item->kategori ?? ''), 'fatayat')),
        ];

        return view('desas.index', compact('desa'));
    }

    /**
     * Tampilkan Halaman Struktur Pengurus
     */
    public function struktur()
    {
        $banomList = [
            'ipnu' => [
                'title' => 'IPNU & IPPNU',
                'pengurus' => [
                    ['nama' => 'Wanda Destiyana', 'jabatan' => 'Ketua IPNU Tanfidziyah'],
                    ['nama' => 'Wulan Alfi', 'jabatan' => 'Wakil IPPNU Tanfidziyah'],
                    ['nama' => 'Laelia Zahro', 'jabatan' => 'Sekretaris Utama Tanfidziyah'],
                    ['nama' => 'M. Daud', 'jabatan' => 'Bendahara Utama Tanfidziyah']
                ]
            ],
            'banser' => [
                'title' => 'BANSER',
                'pengurus' => [
                    ['nama' => 'Ndan Bambang S.', 'jabatan' => 'Kasatkoryon'],
                    ['nama' => 'Ndan Eko P.', 'jabatan' => 'Wakasatkoryon'],
                    ['nama' => 'Ndan Hadi S.', 'jabatan' => 'Kepala Provost']
                ]
            ],
            'muslimat' => [
                'title' => 'MUSLIMAT NU',
                'pengurus' => [
                    ['nama' => 'Hj. Siti Aminah', 'jabatan' => 'Ketua Muslimat'],
                    ['nama' => 'Hj. Nur Jannah', 'jabatan' => 'Sekretaris'],
                    ['nama' => 'Hj. Khotimah', 'jabatan' => 'Bendahara']
                ]
            ],
            'fatayat' => [
                'title' => 'FATAYAT NU',
                'pengurus' => [
                    ['nama' => 'Sahabat Rina M.', 'jabatan' => 'Ketua Fatayat'],
                    ['nama' => 'Sahabat Dewi A.', 'jabatan' => 'Sekretaris'],
                    ['nama' => 'Sahabat Fitri N.', 'jabatan' => 'Bendahara']
                ]
            ]
        ];

        return view('desas.struktur', compact('banomList'));
    }

    /**
     * Tampilkan form untuk membuat berita baru.
     */
    public function create(Request $request)
    {
        $kategoriSelected = $request->query('kategori', 'ipnu');

        return view('desas.create', compact('kategoriSelected'));
    }

    /**
     * Simpan berita baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judulberita' => 'required|string|max:255',
            'isiberita'   => 'required|string',
            'kategori'    => 'required|in:ipnu,banser,muslimat,fatayat',
            'tanggal'     => 'required|date',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        Desa::create($validated);

        return redirect()->route('desas.index')->with('success', 'Berita berhasil ditambahkan!');
    }

    /**
     * Tampilkan detail berita.
     */
    public function show(Desa $desa)
    {
        // Variabel dikirim sebagai 'berita' agar sesuai dengan Blade template
        return view('desas.show', [
            'berita' => $desa
        ]);
    }

    /**
     * Tampilkan form edit berita.
     */
    public function edit(Desa $desa)
    {
        return view('desas.edit', compact('desa'));
    }

    /**
     * Perbarui data berita di database.
     */
    public function update(Request $request, Desa $desa)
    {
        $validated = $request->validate([
            'judulberita' => 'required|string|max:255',
            'isiberita'   => 'required|string',
            'kategori'    => 'required|in:ipnu,banser,muslimat,fatayat',
            'tanggal'     => 'required|date',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada di Storage lokal
            if (!empty($desa->gambar) && !str_starts_with($desa->gambar, 'http') && Storage::disk('public')->exists($desa->gambar)) {
                Storage::disk('public')->delete($desa->gambar);
            }

            $validated['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        $desa->update($validated);

        return redirect()->route('desas.index')->with('success', 'Berita berhasil diperbarui!');
    }

    /**
     * Hapus berita dari database beserta file gambarnya.
     */
    public function destroy(Desa $desa)
    {
        if (!empty($desa->gambar) && !str_starts_with($desa->gambar, 'http') && Storage::disk('public')->exists($desa->gambar)) {
            Storage::disk('public')->delete($desa->gambar);
        }

        $desa->delete();

        return redirect()->route('desas.index')->with('success', 'Berita berhasil dihapus!');
    }
}