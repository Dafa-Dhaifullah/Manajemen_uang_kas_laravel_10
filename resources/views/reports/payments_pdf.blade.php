
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Pembayaran - {{ getMonthName($period->month) }} {{ $period->year }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
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
        }
        .text-center {
            text-align: center;
        }
        .badge {
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 10px;
            color: white;
        }
        .bg-success {
            background-color: #28a745;
        }
        .bg-danger {
            background-color: #dc3545;
        }
        .total {
            margin-top: 20px;
            font-weight: bold;
        }
        .header {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Pembayaran - {{ getMonthName($period->month) }} {{ $period->year }}</h2>
    </div>

    <table>
        <thead>
            <tr>
                <th>NIS</th>
                <th>Nama</th>
                <th>Minggu 1</th>
                <th>Minggu 2</th>
                <th>Minggu 3</th>
                <th>Minggu 4</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            <tr>
                <td>{{ $student->student_id }}</td>
                <td>{{ $student->name }}</td>
                @foreach(range(1, 4) as $week)
                    @php
                        $payment = $student->payments->where('week', $week)->first();
                    @endphp
                    <td class="text-center">
                        @if($payment)
                            <span class="badge bg-success">Sudah Bayar</span>
                        @else
                            <span class="badge bg-danger">Belum Bayar</span>
                        @endif
                    </td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        Total Pembayaran: Rp {{ number_format($totalPayments, 0, ',', '.') }}
    </div>
</body>
</html>