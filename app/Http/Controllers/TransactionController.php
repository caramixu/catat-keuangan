<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        // Mengambil transaksi user yang sedang login
        $transactions = Transaction::where('user_id', Auth::id())->latest()->get();
        
        // Hitung ringkasan
        $totalPemasukan = $transactions->where('type', 'income')->sum('amount');
        $totalPengeluaran = $transactions->where('type', 'expense')->sum('amount');
        $saldo = $totalPemasukan - $totalPengeluaran;

        return view('dashboard', compact('transactions', 'saldo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'type' => 'required|in:income,expense',
        ]);

        Transaction::create([
            'user_id' => Auth::id(),
            'description' => $request->description,
            'amount' => $request->amount,
            'type' => $request->type,
        ]);

        return redirect()->back()->with('success', 'Transaksi berhasil dicatat!');
    }
}