<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Pengeluaran</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            margin-bottom: 20px;
        }
        .period {
            margin-bottom: 15px;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .amount {
            text-align: right;
        }
        .total {
            margin-top: 20px;
            font-size: 14px;
            font-weight: bold;
        }
        .page-break {
            page-break-after: always;
        }
        
        .page-break:last-child {
            page-break-after: avoid;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Pengeluaran</h2>
    </div>

    <div class="period">
        Periode: {{ $request->start_date }} sampai {{ $request->end_date }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Deskripsi</th>
                <th class="amount">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($expenses as $expense)
            <tr>
                <td>{{ \Carbon\Carbon::parse($expense->expense_date)->format('Y-m-d') }}</td>
                <td>{{ $expense->description }}</td>
                <td class="amount">Rp {{ number_format($expense->amount, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        Total Pengeluaran: Rp {{ number_format($totalExpenses, 0, ',', '.') }}
    </div>
</body>
</html>