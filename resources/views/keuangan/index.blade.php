@extends('layouts.main')

@section('title', 'Keuangan')
@section('content')
<main class="main-content position-relative border-radius-lg ">

    <!-- Modal Alert Sukses -->
    @if (session('success'))
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="successModalLabel">Berhasil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ session('success') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus transaksi <span id="deleteDeskripsi" class="fw-bold"></span>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="container mt-4 d-flex align-items-center justify-content-between">
        <div>
            <h4 class="mb-0 main-header" style="color: white; font-weight: bold;">Daftar Transaksi</h4>
            <p class="main-paragraph mb-0" style="color: white; font-weight: bold;">Total Transaksi: {{ $keuangans->count() }} Transaksi</p>
        </div>
        <div>
            <a href="{{ route('keuangan.create') }}" class="btn btn-success btn-input-green me-2">INPUT TRANSAKSI</a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4 mt-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Transaksi Masuk</p>
                                <h5 class="font-weight-bolder">Rp.{{ number_format($totalMasuk, 0, ',', '.') }}</h5>
                                <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+55%</span> sejak minggu terakhir</p>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4 mt-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Transaksi Keluar</p>
                                <h5 class="font-weight-bolder">Rp.{{ number_format($totalKeluar, 0, ',', '.') }}</h5>
                                <p class="mb-0"><span class="text-danger text-sm font-weight-bolder">+3%</span> sejak minggu terakhir</p>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4 mt-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Selisih</p>
                                <h5 class="font-weight-bolder">Rp.{{ number_format($selisih, 0, ',', '.') }}</h5>
                                <p class="mb-0"><span class="text-info text-sm font-weight-bolder">+12%</span> sejak minggu terakhir</p>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid py-6">
        <div class="container-fluid py-4">
            <form action="{{ route('keuangan.index') }}" method="GET">
                <div class="d-flex align-items-center mb-4">
                    <select name="kategori" class="form-control me-2" onchange="this.form.submit()">
                        <option value="">-- Semua Kategori --</option>
                        <option value="Masuk" @if(request()->kategori == 'Masuk') selected @endif>Masuk</option>
                        <option value="Keluar" @if(request()->kategori == 'Keluar') selected @endif>Keluar</option>
                    </select>
                </div>
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Deskripsi Transaksi</th>
                                    <th>Kategori</th>
                                    <th>Jumlah</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($keuangans as $item)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                                    <td>{{ $item->deskripsi }}</td>
                                    <td class="{{ $item->kategori == 'Masuk' ? 'text-success' : 'text-danger' }}">{{ $item->kategori }}</td>
                                    <td>Rp.{{ number_format($item->jumlah, 0, ',', '.') }}</td>
                                    <td>
                                        <a href="{{ route('keuangan.show', $item->id) }}" class="btn btn-info btn-sm">Show</a>
                                        <a href="{{ route('keuangan.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $item->id }}" data-deskripsi="{{ $item->deskripsi }}">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>
    </div>
</main>

@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
    });
</script>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var transaksiId = button.getAttribute('data-id');
            var deskripsi = button.getAttribute('data-deskripsi');

            var deleteForm = deleteModal.querySelector('#deleteForm');
            var deleteDeskripsi = deleteModal.querySelector('#deleteDeskripsi');

            deleteForm.action = "{{ url('keuangan') }}/" + transaksiId;
            deleteDeskripsi.textContent = deskripsi;
        });
    });
</script>


@endsection