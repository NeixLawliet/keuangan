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
    <img src="img/logo.png" style="width: 90px; height:auto; position: absolute; z-index: -99; mix-blend-mode: multiply; top: 50px;">
    <h2>"Glow Happily, <strong>Naturally</strong></h2>
        <p style="margin-left: 100px; margin-right: 100px;">Komplek Tanjung Sari Asri Residence Kav D no 3, Antapani, Bandung</p>
        <p>Email: happy.go.mask.powder@gmail.com | Telepon: 0851-3638-0163</p>
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