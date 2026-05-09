<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        $month = (int) $request->input('month', date('m'));
        $year = (int) $request->input('year', date('Y'));

        $query = Transaction::where('user_id', $userId)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->with('category')
            ->orderBy('date', 'asc');

        // Ambil data berdasarkan tipe transaksi, bukan tipe kategori
        $pemasukan = (clone $query)->where('type', 'income')->get();
        $totalPemasukan = $pemasukan->sum('amount');

        $pengeluaran = (clone $query)->where('type', 'expense')->get();
        $totalPengeluaran = $pengeluaran->sum('amount');

        $arusKas = $totalPemasukan - $totalPengeluaran;

        return view('reports.index', compact(
            'pemasukan',
            'totalPemasukan',
            'pengeluaran',
            'totalPengeluaran',
            'arusKas',
            'month',
            'year'
        ));
    }

    public function exportPdf(Request $request)
    {
        $userId = Auth::id();
        $month = (int) $request->input('month', date('m'));
        $year = (int) $request->input('year', date('Y'));

        $query = Transaction::where('user_id', $userId)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->with('category')
            ->orderBy('date', 'asc');

        $pemasukan = (clone $query)->where('type', 'income')->get();
        $totalPemasukan = $pemasukan->sum('amount');

        $pengeluaran = (clone $query)->where('type', 'expense')->get();
        $totalPengeluaran = $pengeluaran->sum('amount');

        $arusKas = $totalPemasukan - $totalPengeluaran;

        // Load view khusus untuk PDF dengan data yang sama
        $pdf = Pdf::loadView('reports.print', compact(
            'pemasukan',
            'totalPemasukan',
            'pengeluaran',
            'totalPengeluaran',
            'arusKas',
            'month',
            'year'
        ));

        // Mengatur ukuran kertas dan orientasi (A4 Portrait)
        $pdf->setPaper('a4', 'portrait');

        // stream() berfungsi untuk membuka PDF di tab baru, bukan langsung mendownloadnya
        return $pdf->stream('OMJ-Financial-Report-' . $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '.pdf');
    }
}
