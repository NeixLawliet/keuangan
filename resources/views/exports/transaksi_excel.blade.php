<table>
    <thead>
        <tr>
            <th>Bulan</th>
            <th>Jumlah Transaksi</th>
            <th>Pemasukan</th>
            <th>Pengeluaran</th>
            <th>Selisih</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tableData as $bulan => $data)
        <tr>
            <td>{{ $bulan }}</td>
            <td>{{ $data['transaksi'] }}</td>
            <td>{{ $data['pemasukan'] }}</td>
            <td>{{ $data['pengeluaran'] }}</td>
            <td>{{ $data['selisih'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
