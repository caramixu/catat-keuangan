<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>OMJ Financial Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #000;
            font-size: 10pt;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 24pt;
            margin: 0;
            font-weight: bold;
        }

        .header p {
            margin: 5px 0;
            font-size: 11pt;
            letter-spacing: 1px;
        }

        .section-title {
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border: 2px solid #000;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
            text-align: center;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .font-bold {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>OMJ!</h1>
        <p>OH MY JAJAN! • CATAT KEUANGANMU </p>
        <p class="font-bold">LAPORAN KEUANGAN - PERIODE:
            {{ \Carbon\Carbon::create()->month((int) $month)->translatedFormat('F') }}
            {{ $year }}</p>
    </div>

    <div class="section-title">I. DATA PEMASUKAN</div>
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Tanggal</th>
                <th width="25%">Kategori</th>
                <th width="35%">Keterangan</th>
                <th width="20%">Nominal</th>
            </tr>
        </thead>
        <tbody>
            @php $noIn = 1; @endphp
            @forelse($pemasukan as $trx)
                <tr>
                    <td class="text-center">{{ $noIn++ }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($trx->date)->format('d/m/Y') }}</td>
                    <td>{{ $trx->category->nama_kategori ?? 'Tanpa Kategori' }}</td>
                    <td>{{ $trx->description }}</td>
                    <td class="text-right">Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data pemasukan</td>
                </tr>
            @endforelse
            <tr>
                <td colspan="4" class="text-right font-bold">TOTAL PEMASUKAN</td>
                <td class="text-right font-bold">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="section-title">II. DATA PENGELUARAN</div>
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Tanggal</th>
                <th width="25%">Kategori</th>
                <th width="35%">Keterangan</th>
                <th width="20%">Nominal</th>
            </tr>
        </thead>
        <tbody>
            @php $noOut = 1; @endphp
            @forelse($pengeluaran as $trx)
                <tr>
                    <td class="text-center">{{ $noOut++ }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($trx->date)->format('d/m/Y') }}</td>
                    <td>{{ $trx->category->nama_kategori ?? 'Tanpa Kategori' }}</td>
                    <td>{{ $trx->description }}</td>
                    <td class="text-right">Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data pengeluaran</td>
                </tr>
            @endforelse
            <tr>
                <td colspan="4" class="text-right font-bold">TOTAL PENGELUARAN</td>
                <td class="text-right font-bold">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <table>
        <tr style="background-color: #e5e5e5;">
            <td width="80%" class="text-right font-bold" style="font-size: 12pt;">SALDO AKHIR (NET)</td>
            <td width="20%" class="text-right font-bold" style="font-size: 12pt;">Rp
                {{ number_format($arusKas, 0, ',', '.') }}</td>
        </tr>
    </table>

</body>

</html>
