<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keuangan;
use App\Models\Inventory;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BarangExport;
use App\Exports\TransaksiExport;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->kategori;
        $bulan = $request->bulan;
        $bulan_barang = $request->bulan_barang;

        if (!is_numeric($bulan) || $bulan < 1 || $bulan > 12) {
            $bulan = null;
        }

        $keuangans = Keuangan::when($kategori, function ($query) use ($kategori) {
                return $query->where('kategori', ucfirst(strtolower($kategori)));
            })
            ->when($bulan, function ($query) use ($bulan) {
                return $query->whereMonth('tanggal', $bulan);
            })
            ->get();

        $totalMasuk = $keuangans->where('kategori', 'Masuk')->sum('jumlah');
        $totalKeluar = $keuangans->where('kategori', 'Keluar')->sum('jumlah');
        $selisih = $totalMasuk - $totalKeluar;

        // Data untuk tabel
        $tableData = $keuangans
            ->groupBy(function ($item) {
                return Carbon::parse($item->tanggal)->translatedFormat('F');
            })
            ->map(function ($group) {
                return [
                    'transaksi' => $group->count(),
                    'pemasukan' => $group->where('kategori', 'Masuk')->sum('jumlah'),
                    'pengeluaran' => $group->where('kategori', 'Keluar')->sum('jumlah'),
                    'selisih' => $group->where('kategori', 'Masuk')->sum('jumlah') - $group->where('kategori', 'Keluar')->sum('jumlah'),
                ];
            });

        // Data untuk Chart Keuangan
        $keuanganData = [
            'masuk' => [],
            'keluar' => []
        ];

        for ($month = 1; $month <= 12; $month++) {
            $masuk = Keuangan::where('kategori', 'Masuk')->whereMonth('tanggal', $month)->sum('jumlah');
            $keluar = Keuangan::where('kategori', 'Keluar')->whereMonth('tanggal', $month)->sum('jumlah');

            $keuanganData['masuk'][] = $masuk;
            $keuanganData['keluar'][] = $keluar;
        }

        // Membuat Grafik Keuangan
        $keuanganChart = new Chart;
        $keuanganChart->labels(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
        $keuanganChart->dataset('Transaksi Masuk', 'line', $keuanganData['masuk'])->color('#00ff00');
        $keuanganChart->dataset('Transaksi Keluar', 'line', $keuanganData['keluar'])->color('#ff0000');

        // Query untuk Barang Data
        $queryBarang = Inventory::select(
            DB::raw('DATE_FORMAT(tanggal, "%m") as bulan'),
            'nama_barang',
            DB::raw('SUM(CASE WHEN kategori = "Masuk" THEN jumlah ELSE 0 END) as barang_masuk'),
            DB::raw('SUM(CASE WHEN kategori = "Keluar" THEN jumlah ELSE 0 END) as barang_keluar'),
            DB::raw('SUM(CASE WHEN kategori = "Masuk" THEN jumlah ELSE 0 END) - SUM(CASE WHEN kategori = "Keluar" THEN jumlah ELSE 0 END) as stok')
        )
        ->when($bulan_barang, function ($query) use ($bulan_barang) {
            return $query->whereMonth('tanggal', $bulan_barang);
        })
        ->groupBy('bulan', 'nama_barang')
        ->orderBy(DB::raw('CAST(bulan AS UNSIGNED)'))
        ->get();        

        // Memastikan Bulan Tidak Berubah
        $barangData = $queryBarang->map(function ($item) {
            $item->bulan = Carbon::createFromFormat('m', $item->bulan)->translatedFormat('F');
            return $item;
        });

        // Data untuk Grafik Inventory
        $barangMasuk = Inventory::where('kategori', 'Masuk')->sum('jumlah');
        $barangKeluar = Inventory::where('kategori', 'Keluar')->sum('jumlah');

        $inventoryChart = new Chart;
        $inventoryChart->labels(['Barang Masuk', 'Barang Keluar']);
        $inventoryChart->dataset('Barang Masuk', 'bar', [$barangMasuk, 0])->color('#00ff00');
        $inventoryChart->dataset('Barang Keluar', 'bar', [0, $barangKeluar])->color('#ff0000');

        return view('laporan.index', compact(
            'keuangans',
            'totalMasuk',
            'totalKeluar',
            'selisih',
            'tableData',
            'keuanganChart',
            'inventoryChart',
            'barangData'
        ));
    }

    public function downloadTransaksiPDF(Request $request)
    {
        $bulan = $request->bulan;

        $keuangans = Keuangan::when($bulan, function ($query) use ($bulan) {
                return $query->whereMonth('tanggal', $bulan);
            })
            ->get();

        $tableData = $keuangans
            ->groupBy(function ($item) {
                return Carbon::parse($item->tanggal)->translatedFormat('F');
            })
            ->map(function ($group) {
                return [
                    'transaksi' => $group->count(),
                    'pemasukan' => $group->where('kategori', 'Masuk')->sum('jumlah'),
                    'pengeluaran' => $group->where('kategori', 'Keluar')->sum('jumlah'),
                    'selisih' => $group->where('kategori', 'Masuk')->sum('jumlah') - $group->where('kategori', 'Keluar')->sum('jumlah'),
                ];
            });

        $pdf = FacadePdf::loadView('laporan.laporan_pdf_transaksi', compact('tableData'));

        return $pdf->download('laporan-transaksi.pdf');
    }

    public function downloadBarangPDF(Request $request)
    {
        $bulan = $request->bulan;

        $queryBarang = Inventory::select(
            DB::raw('MONTH(tanggal) as bulan'),
            'nama_barang',
            DB::raw('SUM(CASE WHEN kategori = "Masuk" THEN jumlah ELSE 0 END) as barang_masuk'),
            DB::raw('SUM(CASE WHEN kategori = "Keluar" THEN jumlah ELSE 0 END) as barang_keluar'),
            DB::raw('SUM(CASE WHEN kategori = "Masuk" THEN jumlah ELSE 0 END) - SUM(CASE WHEN kategori = "Keluar" THEN jumlah ELSE 0 END) as stok')
        )
        ->when($bulan, function ($query) use ($bulan) {
            return $query->whereMonth('tanggal', $bulan);
        })
        ->groupBy('bulan', 'nama_barang')
        ->orderBy(DB::raw('MONTH(tanggal)'))
        ->get();

        $barangData = $queryBarang->map(function ($item) {
            $item->bulan = Carbon::createFromFormat('m', $item->bulan)->translatedFormat('F');
            return $item;
        });

        $pdf = FacadePdf::loadView('laporan.laporan_pdf_barang', compact('barangData'));

        return $pdf->download('laporan-barang.pdf');
    }

    public function downloadBarangExcel(Request $request)
    {
        $bulan = $request->bulan;
        return Excel::download(new BarangExport($bulan), 'laporan-barang.xlsx');
    }

    public function downloadTransaksiExcel(Request $request)
    {
        $bulan = $request->bulan;
        return Excel::download(new TransaksiExport($bulan), 'laporan-transaksi.xlsx');
    }

    

    
}
