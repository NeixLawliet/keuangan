@extends('layouts.main')

@section('content')
<main class="main-content position-relative border-radius-lg">
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg mt-5" style="width: 700px; border-radius: 15px;">
            <!-- Bagian atas card -->
            <div class="card-header bg-primary text-white text-center" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                <h4 class="mb-0 font-weight-bold text-white">Input Barang Keluar</h4>
            </div>
            
            <!-- Bagian bawah card -->
            <div class="card-body bg-white">
                <form action="{{ route('inventory.keluar.store') }}" method="POST">
                    @csrf
                    <!-- Dropdown Barang -->
                    <div class="form-group mb-3">
                        <label for="id">Pilih Barang</label>
                        <select name="id" id="id" class="form-control" required>
                            <option value="">-- Pilih Barang --</option>
                            @forelse($barangList as $barang)
                                <option value="{{ $barang->id }}">{{ $barang->nama_barang }}</option>
                            @empty
                                <option value="">Tidak ada barang tersedia</option>
                            @endforelse
                        </select>
                        @error('id')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Input Tanggal -->
                    <div class="form-group mb-3">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal') }}" required>
                        @error('tanggal')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Input Jumlah -->
                    <div class="form-group mb-3">
                        <label for="jumlah">Jumlah Barang Keluar</label>
                        <input type="number" name="jumlah" id="jumlah" class="form-control" value="{{ old('jumlah') }}" min="1" required>
                        @error('jumlah')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Tombol Simpan -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
