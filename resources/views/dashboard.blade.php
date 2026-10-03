<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Modal Tambah User (Letakkan di Dashboard Admin) -->
<div class="modal fade" id="modalTambahUser" tabindex="-1" aria-labelledby="modalUserLabel" aria-hidden="true">
  <div class="modal-dialog">
    <divs class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="modalUserLabel">Tambah Anggota / User Baru</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="modal-body">
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" required placeholder="Sesuai KTP / KTA">
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Badan Otonom (Banom)</label>
                <select name="banom" class="form-select" required>
                    <option value="" disabled selected>-- Pilih Banom --</option>
                    <option value="ipnu">IPNU</option>
                    <option value="ippnu">IPPNU</option>
                    <option value="banser">BANSER</option>
                    <option value="ansor">GP ANSOR</option>
                    <option value="fatayat">Fatayat NU</option>
                    <option value="muslimat">Muslimat NU</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Role Access</label>
                <select name="role" class="form-select" required>
                    <option value="user" selected>User / Anggota</option>
                    <option value="admin">Administrator</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email" class="form-control" required placeholder="email@domain.com">
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Password Default</label>
                <input type="password" name="password" class="form-control" required placeholder="Minimal 6 Karakter">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-success">Simpan Akun</button>
        </div>
      </form>
    </div>
  </div>
</div>