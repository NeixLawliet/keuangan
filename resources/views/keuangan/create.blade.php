@extends('layouts.main')
@section('title', 'Input Transaksi')

@section('content')
<main class="main-content position-relative border-radius- mb-4">
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white text-center">
                        <h3 class="text-light">Input Transaksi</h3>
                    </div>
                    <div class="card-body">
                        <!-- Notifikasi Error -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> Ada masalah dengan input Anda.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Notifikasi Sukses -->
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Form Input Transaksi -->
                        <form id="transactionForm" action="{{ route('keuangan.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="kategori" class="form-label">Kategori</label>
                                <select name="kategori" class="form-control" required>
                                    <option value="Masuk">Transaksi Masuk</option>
                                    <option value="Keluar">Transaksi Keluar</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi Transaksi</label>
                                <textarea name="deskripsi" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="jumlah" class="form-label">Jumlah</label>
                                <input type="number" name="jumlah" class="form-control" required>
                            </div>
                            <div class="text-center">
                                <!-- Tombol untuk membuka modal -->
                                <button type="button" class="btn btn-success" id="openConfirmModal">Simpan Transaksi</button>
                                <a href="{{ route('keuangan.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Simpan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menyimpan data ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="confirmSave">Ya, Simpan</button>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const openModalButton = document.getElementById('openConfirmModal');
        const confirmSaveButton = document.getElementById('confirmSave');
        const form = document.getElementById('transactionForm');

        // Membuka modal konfirmasi
        openModalButton.addEventListener('click', () => {
            // Validasi input sebelum membuka modal
            if (form.checkValidity()) {
                const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
                confirmModal.show();
            } else {
                alert('Mohon lengkapi semua field sebelum menyimpan.');
            }
        });

        // Mengirimkan form setelah konfirmasi
        confirmSaveButton.addEventListener('click', () => {
            form.submit();
        });
    });
</script>
@endsection
