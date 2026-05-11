<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');

        $type = $request->input('type', 'pemasukan');

        $dbType = ($type === 'pemasukan') ? 'income' : 'expense';

        $transactions = Transaction::with('category')
            ->where('user_id', Auth::id())
            ->where('type', $dbType)
            ->orderBy($sortBy, $sortOrder)
            ->paginate($perPage)
            ->withQueryString();

        $categories = Category::where('user_id', Auth::id())->get();

        return view('transactions.index', compact(
            'transactions',
            'type',
            'categories',
            'perPage',
            'sortBy',
            'sortOrder'
        ));
    }

    public function dashboard()
    {
        $transactions = Transaction::with('category')->where('user_id', Auth::id())->latest()->get();

        $totalPemasukan = $transactions->where('type', 'income')->sum('amount');
        $totalPengeluaran = $transactions->where('type', 'expense')->sum('amount');
        $saldo = $totalPemasukan - $totalPengeluaran;

        $categories = Category::where('user_id', Auth::id())->get();

        return view('dashboard', compact('transactions', 'saldo', 'totalPemasukan', 'totalPengeluaran', 'categories'));
    }

    public function store(Request $request)
    {
        if ($request->type === 'pemasukan') {
            $request->merge(['type' => 'income']);
        } elseif ($request->type === 'pengeluaran') {
            $request->merge(['type' => 'expense']);
        }

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string|max:255',
            'amount'      => 'required|numeric|min:1',
            'date'        => 'required|date|before_or_equal:today',
            'type'        => 'required|in:income,expense',
            'proof'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $proofPath = $request->hasFile('proof')
            ? $request->file('proof')->store('transaction_proofs', 'public')
            : null;

        Transaction::create([
            'user_id'     => Auth::id(),
            'category_id' => $request->category_id,
            'type'        => $request->type,
            'amount'      => $request->amount,
            'date'        => $request->date,
            'description' => $request->description,
            'proof'       => $proofPath,
        ]);

        return redirect()->back()->with('success', 'Transaksi berhasil dicatat!');
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'category_id' => 'required',
            'description' => 'required|string|max:255',
            'amount'      => 'required|numeric|min:1',
            'date'        => 'required|date|before_or_equal:today',
            'proof'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ], [
            'amount.min' => 'Nominal tidak boleh 0 atau minus!',
            'date.before_or_equal' => 'Tanggal tidak boleh melebihi hari ini!'
        ]);

        $transaction = Transaction::where('user_id', Auth::id())->findOrFail($id);

        $dataUpdate = [
            'category_id' => $request->category_id,
            'amount'      => $request->amount,
            'date'        => $request->date,
            'description' => $request->description,
        ];

        if ($request->remove_proof == '1' && $transaction->proof) {
            Storage::disk('public')->delete($transaction->proof);
            $dataUpdate['proof'] = null;
        }

        if ($request->hasFile('proof')) {
            if ($transaction->proof) {
                Storage::disk('public')->delete($transaction->proof);
            }
            $dataUpdate['proof'] = $request->file('proof')->store('transaction_proofs', 'public');
        }

        $transaction->update($dataUpdate);

        return redirect()->back()->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function destroy(Request $request, string $id)
    {
        $transaction = Transaction::where('user_id', Auth::id())->findOrFail($id);
        $type = ($transaction->type == 'income') ? 'pemasukan' : 'pengeluaran';

        $currentPage = $request->input('page', 1);
        $perPage = $request->input('per_page', 10);

        $transaction->delete();

        // Hitung sisa transaksi BERDASARKAN TIPE
        $remaining = Transaction::where('user_id', Auth::id())
            ->where('type', $transaction->type)
            ->count();

        if ($remaining == 0) {
            $targetPage = 1;
        } else {
            $maxPage = ceil($remaining / $perPage);
            $targetPage = ($currentPage > $maxPage) ? $maxPage : $currentPage;
        }

        return redirect()->route('transactions.index', [
            'type' => $type,
            'page' => $targetPage,
            'per_page' => $perPage
        ])->with('success', 'Transaksi berhasil dihapus!');
    }
}
