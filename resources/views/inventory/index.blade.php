@extends('layouts.main')

@section('title', 'Inventory')
@section('content')
<main class="main-content position-relative border-radius-lg">


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

    <div class="container mt-4 d-flex align-items-center justify-content-between">
        <div>
            <h4 class="mb-0 main-header" style="color: white; font-weight: bold;">Daftar Barang</h4>
            <p class="main-paragraph mb-0" style="color: white; font-weight: bold;">
                 Total Barang: {{ $stokBarang->sum('stok') }} Barang
            </p>
        </div>
        <div>
            <a href="{{ route('inventory.create') }}" class="btn btn-success btn-input-green me-2">INPUT BARANG MASUK</a>
            <a href="{{ route('inventory.keluar.create') }}" class="btn btn-danger btn-input-red me-2">INPUT BARANG KELUAR</a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4 mt-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Barang Masuk</p>
                                <h5 class="font-weight-bolder">{{ number_format($totalMasuk, 0, ',', '.') }}</h5>
                                <p class="mb-0">
                                    <span class="text-success text-sm font-weight-bolder"></span> sejak minggu terakhir
                                </p>
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
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Barang Keluar</p>
                                <h5 class="font-weight-bolder">{{ number_format($totalKeluar, 0, ',', '.') }}</h5>
                                <p class="mb-0">
                                    <span class="text-danger text-sm font-weight-bolder"></span> sejak minggu terakhir
                                </p>
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
    </div>

    <div class="container-fluid py-6">
        <div class="container-fluid py-4">
            <form action="{{ route('inventory.index') }}" method="GET">
                <div class="d-flex align-items-center mb-4">
                    <select name="kategori" class="form-control me-2" onchange="this.form.submit()">
                        <option value="">-- Semua Kategori --</option>
                        <option value="Masuk" @if(request()->kategori == 'Masuk') selected @endif>Masuk</option>
                        <option value="Keluar" @if(request()->kategori == 'Keluar') selected @endif>Keluar</option>
                    </select>
                </div>
            </form>
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Jumlah</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($inventory as $item)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                                    <td>{{ $item->nama_barang }}</td>
                                    <td class="{{ $item->kategori == 'Masuk' ? 'text-success' : 'text-danger' }}">
                                        {{ $item->kategori }}
                                    </td>
                                    <td>{{ number_format($item->jumlah, 0, ',', '.') }}</td>
                                    <td>
                                        <a href="{{ route('inventory.show', $item->id) }}" class="btn btn-info btn-sm">Show</a>
                                        <a href="{{ route('inventory.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('inventory.destroy', $item->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="card mt-4">
                        <div class="card-body">
                            <h5>Stok Barang</h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($stokBarang as $barang)
                                        <tr>
                                            <td>{{ $barang->nama_barang }}</td>
                                            <td>{{ number_format($barang->stok, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
        });
    </script>
@endif
@endsection
