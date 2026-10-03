<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnggotaController extends Controller
{
    /**
     * READ: Menampilkan daftar seluruh data anggota
     */
    public function index()
    {
        $anggota = Anggota::latest()->get();
        return view('desas.data', compact('anggota'));
    }

    /**
     * CREATE: Menampilkan formulir untuk menambah data anggota baru
     */
    public function create()
    {
        return view('desas.createdata');
    }

    /**
     * CREATE: Menyimpan data anggota baru ke dalam database
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'    => 'required|string|max:255',
            'alamat'  => 'required|string',
            'nohp'    => 'required|string|max:20',
            'jabatan' => 'required|string|max:100',
            'gambar'  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Proses simpan file gambar jika diunggah
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('anggota', 'public');
        }

        Anggota::create($data);

        return redirect()->route('anggota.index')
                         ->with('success', 'Data anggota berhasil ditambahkan.');
    }

    /**
     * READ: Menampilkan detail satu data anggota berdasarkan ID
     */
    public function show($id)
    {
        $anggota = Anggota::findOrFail($id);
        return view('desas.show', compact('anggota'));
    }

    /**
     * UPDATE: Menampilkan formulir untuk mengedit data anggota
     */
    public function edit($id)
    {
        $anggota = Anggota::findOrFail($id);
        return view('desas.editdata', compact('anggota'));
    }

    /**
     * UPDATE: Memperbarui data anggota yang ada di database
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nama'    => 'required|string|max:255',
            'alamat'  => 'required|string',
            'nohp'    => 'required|string|max:20',
            'jabatan' => 'required|string|max:100',
            'gambar'  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $anggota = Anggota::findOrFail($id);

        // Jika ada gambar baru yang diunggah, hapus gambar lama dan simpan yang baru
        if ($request->hasFile('gambar')) {
            if ($anggota->gambar && Storage::disk('public')->exists($anggota->gambar)) {
                Storage::disk('public')->delete($anggota->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('anggota', 'public');
        }

        $anggota->update($data);

        return redirect()->route('anggota.index')
                         ->with('success', 'Data anggota berhasil diperbarui.');
    }

    /**
     * DELETE: Menghapus data anggota dari database
     */
    public function destroy($id)
    {
        $anggota = Anggota::findOrFail($id);

        // Hapus file gambar dari storage jika ada
        if ($anggota->gambar && Storage::disk('public')->exists($anggota->gambar)) {
            Storage::disk('public')->delete($anggota->gambar);
        }

        $anggota->delete();

        return redirect()->route('anggota.index')
                         ->with('success', 'Data anggota berhasil dihapus.');
    }
}