@extends('layouts.main')
@section('title', 'Edit Transaksi')

@section('content')
<main class="main-content position-relative border-radius-lg">
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg" style="width: 700px; border-radius: 15px;">
            <div class="card-header bg-primary text-white text-center" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                <h4 class="mb-0 font-weight-bold text-white">Edit Transaksi</h4>
            </div>
            <div class="card-body bg-white">
                <form id="editForm" action="{{ route('keuangan.update', $keuangan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $keuangan->tanggal }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <input type="text" class="form-control" id="deskripsi" name="deskripsi" value="{{ $keuangan->deskripsi }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select class="form-control" id="kategori" name="kategori" required>
                            <option value="Masuk" {{ $keuangan->kategori == 'Masuk' ? 'selected' : '' }}>Masuk</option>
                            <option value="Keluar" {{ $keuangan->kategori == 'Keluar' ? 'selected' : '' }}>Keluar</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" value="{{ $keuangan->jumlah }}" required>
                    </div>
                    <div class="text-center">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirmModal">Simpan</button>
                        <a href="{{ route('keuangan.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<!-- Modal Konfirmasi -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Simpan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menyimpan perubahan pada transaksi ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" id="confirmSave">Ya, Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const confirmSave = document.getElementById('confirmSave');
        const editForm = document.getElementById('editForm');

        confirmSave.addEventListener('click', function () {
            editForm.submit(); // Submit form jika pengguna mengonfirmasi
        });
    });
</script>
@endsection
