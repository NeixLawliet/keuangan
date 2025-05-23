<?php
namespace App\Exports;

use App\Models\Inventory;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BarangExport implements FromView
{
    protected $bulan;

    public function __construct($bulan)
    {
        $this->bulan = $bulan;
    }

    public function view(): View
    {
        $queryBarang = Inventory::select(
                DB::raw('MONTH(tanggal) as bulan'),
                'nama_barang',
                DB::raw('SUM(CASE WHEN kategori = "Masuk" THEN jumlah ELSE 0 END) as barang_masuk'),
                DB::raw('SUM(CASE WHEN kategori = "Keluar" THEN jumlah ELSE 0 END) as barang_keluar'),
                DB::raw('SUM(CASE WHEN kategori = "Masuk" THEN jumlah ELSE 0 END) - SUM(CASE WHEN kategori = "Keluar" THEN jumlah ELSE 0 END) as stok')
            )
            ->when($this->bulan, function ($query) {
                return $query->whereMonth('tanggal', $this->bulan);
            })
            ->groupBy('bulan', 'nama_barang')
            ->orderBy(DB::raw('MONTH(tanggal)'))
            ->get();

        $barangData = $queryBarang->map(function ($item) {
            $item->bulan = Carbon::createFromFormat('m', $item->bulan)->translatedFormat('F');
            return $item;
        });

        return view('exports.barang_excel', [
            'barangData' => $barangData
        ]);
    }
}
