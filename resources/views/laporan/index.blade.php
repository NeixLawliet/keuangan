@extends('layouts.main')

@section('title', 'Laporan')
@section('content')
<main class="main-content position-relative border-radius-lg">
    <div class="container-fluid py-4">
        <div class="row mt-4">
            <!-- Grafik Keuangan -->
            <div class="col-lg-6 mb-lg-0 mb-4">
                <div class="card z-index-2 h-100">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">Grafik Keuangan (Transaksi Masuk & Keluar)</h6>
                    </div>
                    <div class="card-body p-3">
                        {!! $keuanganChart->container() !!}
                    </div>
                </div>
            </div>

            <!-- Grafik Inventory -->
            <div class="col-lg-6 mb-lg-0 mb-4">
                <div class="card z-index-2 h-100">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">Grafik Inventory (Barang Masuk & Keluar)</h6>
                    </div>
                    <div class="card-body p-3">
                        {!! $inventoryChart->container() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {!! $keuanganChart->script() !!}
    {!! $inventoryChart->script() !!}

    <!-- Data Transaksi -->
    <div class="card mt-4">
        <div class="card-header pb-0">
            <h6>Data Transaksi</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('laporan.index') }}" class="d-flex align-items-center gap-2 mb-3">
                <select class="form-select" name="bulan" style="width: 150px; height: 38px;">
                    <option value="">Pilih Bulan</option>
                    @foreach (range(1, 12) as $bulan)
                        <option value="{{ $bulan }}" {{ request('bulan') == $bulan ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $bulan)->format('F') }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary" style="height: 42px;">Filter</button>
                <a href="{{ route('laporan.pdf_transaksi', ['bulan' => request('bulan')]) }}" class="btn btn-primary" style="height: 42px;">Download PDF</a>
            </form>    
            <div class="table-responsive">
                <table class="table align-items-center table-sm mb-0" style="font-size: 0.875rem;">
                    <thead>
                        <tr>
                            <th class="text-center">NO</th>
                            <th class="text-center">Bulan</th>
                            <th class="text-center">Transaksi</th>
                            <th class="text-center">Pemasukan</th>
                            <th class="text-center">Pengeluaran</th>
                            <th class="text-center">Selisih</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tableData as $month => $data)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $month }}</td>
                            <td class="text-center">{{ $data['transaksi'] }}</td>
                            <td class="text-center">{{ $data['pemasukan'] ?? 0 }}</td>
                            <td class="text-center">{{ $data['pengeluaran'] ?? 0 }}</td>
                            <td class="text-center">{{ $data['selisih'] ?? 0 }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Data Barang -->
    <div class="card mt-4">
        <div class="card-header pb-0">
            <h6>Data Barang</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('laporan.index') }}" class="d-flex align-items-center gap-2 mb-3">
                <select class="form-select" name="bulan_barang" style="width: 150px; height: 38px;">
                    <option value="">Pilih Bulan</option>
                    @foreach (range(0, 12) as $bulan)
                        <option value="{{ $bulan }}" {{ request('bulan_barang') == $bulan ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $bulan)->format('F') }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary" style="height: 42px;">Filter</button>
                <a href="{{ route('laporan.pdf_barang', ['bulan_barang' => request('bulan_barang')]) }}" class="btn btn-primary" style="height: 42px;">Download PDF</a>
            </form>
            <div class="table-responsive">
                <table class="table align-items-center table-sm mb-0" style="font-size: 0.875rem;">
                    <thead>
                        <tr>
                            <th class="text-center">NO</th>
                            <th class="text-center">Bulan</th>
                            <th class="text-center">Nama Barang</th>
                            <th class="text-center">Barang Masuk</th>
                            <th class="text-center">Barang Keluar</th>
                            <th class="text-center">Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barangData as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $item->bulan }}</td>
                            <td class="text-center">{{ $item->nama_barang }}</td>
                            <td class="text-center">{{ $item->barang_masuk }}</td>
                            <td class="text-center">{{ $item->barang_keluar }}</td>
                            <td class="text-center">{{ $item->stok }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<script>
    const labels = Object.keys(chartData);
    const pemasukanData = Object.values(chartData).map(data => data.pemasukan);
    const pengeluaranData = Object.values(chartData).map(data => data.pengeluaran);

    const ctx = document.getElementById('chart-line').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                    label: 'Pemasukan',
                    data: pemasukanData,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                },
                {
                    label: 'Pengeluaran',
                    data: pengeluaranData,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                },
            ],
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
            },
        },
    });
</script>

@endsection