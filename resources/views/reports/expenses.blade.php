<!-- resources/views/reports/expenses.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container-fluid py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2">Laporan Pengeluaran</h1>
        <a href="{{ route('reports.expenses', ['start_date' => $request->start_date, 'end_date' => $request->end_date, 'export_pdf' => true]) }}" class="btn btn-primary">
            <i class="bi bi-file-pdf"></i> Export PDF
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <h6 class="mb-3">Periode: {{ $request->start_date }} to {{ $request->end_date }}</h6>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Deskripsi</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($expenses as $expense)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($expense->expense_date)->format('Y-m-d') }}</td>
                            <td>{{ $expense->description }}</td>
                            <td>Rp {{ number_format($expense->amount, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <h5>Total Pengeluaran: Rp {{ number_format($totalExpenses, 0, ',', '.') }}</h5>
            </div>
        </div>
    </div>
</div>
@endsection