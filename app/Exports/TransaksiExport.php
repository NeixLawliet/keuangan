<?php

namespace App\Exports;

use App\Models\Keuangan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Carbon\Carbon;

class TransaksiExport implements FromView
{
    protected $bulan;

    public function __construct($bulan)
    {
        $this->bulan = $bulan;
    }

    public function view(): View
    {
        $keuangans = Keuangan::when($this->bulan, function ($query) {
                return $query->whereMonth('tanggal', $this->bulan);
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

        return view('exports.transaksi_excel', [
            'tableData' => $tableData
        ]);
    }
}

