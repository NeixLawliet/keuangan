<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid black;
            padding-bottom: 10px;
        }

        .kop-surat img {
            width: 80px;
            height: auto;
            position: absolute;
            left: 20px;
            top: 10px;
        }

        .kop-surat h2,
        .kop-surat p {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            text-align: center;
            padding: 8px;
        }
    </style>
</head>

<body>

    <div class="kop-surat">
        <img src="img/fiinventory.svg" style="width: 150px; position: absolute; z-index: -99; mix-blend-mode: multiply;">
        <h2>Fiinventory</h2>
        <p style="margin-left: 100px; margin-right: 100px;">Jl. Terusan Sekolah No.1-2, Cicaheum, Kec. Kiaracondong, Kota Bandung, Jawa Barat 40282</p>
        <p>Email: kampus@ars.ac.id | Telepon: 081-222-300-425</p>
    </div>


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
</body>

</html>