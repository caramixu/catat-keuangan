<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Keuangan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-500">
                    <p class="text-sm text-gray-500 uppercase font-bold">Total Saldo</p>
                    <p class="text-2xl font-semibold">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-green-500">
                    <p class="text-sm text-gray-500 uppercase font-bold text-green-600">Pemasukan</p>
                    <p class="text-2xl font-semibold text-green-600">+ Rp {{ number_format($transactions->where('type', 'income')->sum('amount'), 0, ',', '.') }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-red-500">
                    <p class="text-sm text-gray-500 uppercase font-bold text-red-600">Pengeluaran</p>
                    <p class="text-2xl font-semibold text-red-600">- Rp {{ number_format($transactions->where('type', 'expense')->sum('amount'), 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-medium mb-4">Tambah Transaksi Baru</h3>
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg font-bold">
                        {{ session('success') }}
                    </div>
                @endif
                <form action="{{ route('transactions.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <input type="text" name="description" placeholder="Keterangan" class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500" required>
                        <input type="number" name="amount" placeholder="Nominal" class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500" required>
                        <select name="type" class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500">
                            <option value="expense">Pengeluaran</option>
                            <option value="income">Pemasukan</option>
                        </select>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white p-6 rounded-lg shadow overflow-hidden">
                <h3 class="text-lg font-medium mb-4">Riwayat Transaksi</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 border-b">Tanggal</th>
                                <th class="px-4 py-2 border-b">Deskripsi</th>
                                <th class="px-4 py-2 border-b text-right">Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $t)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border-b text-sm">{{ $t->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-2 border-b font-medium">{{ $t->description }}</td>
                                <td class="px-4 py-2 border-b text-right {{ $t->type == 'income' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $t->type == 'income' ? '+' : '-' }} Rp {{ number_format($t->amount, 0, ',', '.') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-4 py-6 text-center text-gray-500 italic">Belum ada transaksi.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>