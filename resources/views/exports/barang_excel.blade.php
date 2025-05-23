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
