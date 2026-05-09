<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil ID user yang sedang login
        $userId = Auth::id();

        // Hitung Total Pemasukan
        $totalPemasukan = Transaction::where('user_id', $userId)
            ->whereHas('category', function ($q) {
                $q->where('tipe', 'pemasukan');
            })->sum('amount');

        // Hitung Total Pengeluaran
        $totalPengeluaran = Transaction::where('user_id', $userId)
            ->whereHas('category', function ($q) {
                $q->where('tipe', 'pengeluaran');
            })->sum('amount');

        // Hitung Uang Dompet (Saldo)
        $uangDompet = $totalPemasukan - $totalPengeluaran;

        // Ambil 5 Transaksi Terakhir
        $recentTransactions = Transaction::with('category')
            ->where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Ambil semua kategori untuk form modal di dashboard
        $categories = Category::all();

        // Kirim semua data ke view 'dashboard'
        return view('dashboard', compact(
            'totalPemasukan',
            'totalPengeluaran',
            'uangDompet',
            'recentTransactions',
            'categories'
        ));
    }
}
