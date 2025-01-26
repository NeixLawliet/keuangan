<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            text-align: center;
            padding: 8px;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Laporan Transaksi</h2>
    <table>
        <thead>
            <tr>
                <th>NO</th>
                <th>Bulan</th>
                <th>Transaksi</th>
                <th>Pemasukan</th>
                <th>Pengeluaran</th>
                <th>Selisih</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tableData as $month => $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $month }}</td>
                    <td>{{ $data['transaksi'] }}</td>
                    <td>Rp.{{ number_format($data['pemasukan'], 0, ',', '.') }}</td>
                    <td>Rp.{{ number_format($data['pengeluaran'], 0, ',', '.') }}</td>
                    <td>Rp.{{ number_format($data['selisih'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <h2 style="text-align: center; margin-top: 40px;">Laporan Barang</h2>
        <table>
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Bulan</th>
                    <th>Nama Barang</th>
                    <th>Barang Masuk</th>
                    <th>Barang Keluar</th>
                    <th>Stok</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($barangData as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->bulan }}</td>
                        <td>{{ $data->nama_barang }}</td>
                        <td>{{ $data->barang_masuk }}</td>
                        <td>{{ $data->barang_keluar }}</td>
                        <td>{{ $data->stok }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
</body>
</html>
