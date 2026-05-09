<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        // 1. Tangkap parameter dari tampilan (Dropdown Tampilkan, Pencarian, Sortir)
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');

        // 2. Query dasar (hanya kategori milik user yang login)
        $query = Category::where('user_id', Auth::id());

        // 3. Logika Pencarian
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_kategori', 'like', "%{$search}%")
                    ->orWhere('tipe', 'like', "%{$search}%");
            });
        }

        // 4. Logika Sortir (Mencegah error nama kolom salah)
        $allowedSorts = ['id', 'nama_kategori', 'tipe'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // 5. Eksekusi Pagination
        $categories = $query->paginate($perPage);

        // Kirim semua variabel ke tampilan
        return view('categories.index', compact('categories', 'perPage', 'search', 'sortBy', 'sortOrder'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $isDuplicate = Category::where('user_id', Auth::id())
            ->where('tipe', $request->tipe)
            ->whereRaw('LOWER(nama_kategori) = ?', [strtolower($request->nama_kategori)])
            ->exists();

        if ($isDuplicate) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['nama_kategori' => 'Nama kategori ini sudah ada (tidak boleh sama meskipun huruf besar/kecil).']);
        }

        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'tipe' => 'required|in:pemasukan,pengeluaran',
            'deskripsi' => 'nullable|string'
        ]);

        Category::create([
            'user_id' => Auth::id(),
            'nama_kategori' => $request->nama_kategori,
            'tipe' => $request->tipe,
            'deskripsi' => $request->deskripsi
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'tipe' => 'required|in:pemasukan,pengeluaran',
            'deskripsi' => 'nullable|string'
        ]);

        $category->update($request->only('nama_kategori', 'tipe', 'deskripsi'));

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(Request $request, Category $category)
    {
        if ($category->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses!');
        }

        $currentPage = $request->input('page', 1);
        $perPage = $request->input('per_page', 10);

        Transaction::where('category_id', $category->id)->update(['category_id' => null]);

        $category->delete();

        $remaining = Category::where('user_id', Auth::id())->count();

        if ($remaining == 0) {
            $targetPage = 1;
        } else {
            $maxPage = ceil($remaining / $perPage);
            $targetPage = ($currentPage > $maxPage) ? $maxPage : $currentPage;
        }

        return redirect()->route('categories.index', [
            'page' => $targetPage,
            'per_page' => $perPage
        ])->with('success', 'Kategori berhasil dihapus!');
    }
}
