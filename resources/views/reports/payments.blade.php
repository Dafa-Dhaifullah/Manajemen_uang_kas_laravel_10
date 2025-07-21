<!-- resources/views/reports/payments.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container-fluid py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2">Laporan Pembayaran - {{ getMonthName($period->month) }} {{ $period->year }}</h1>
        <a href="{{ route('reports.payments', ['period_id' => $period->id, 'export_pdf' => true]) }}" class="btn btn-primary">
            <i class="bi bi-file-pdf"></i> Export PDF
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
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
            </div>

            <div class="mt-4">
                <h5>Total Pembayaran: Rp {{ number_format($totalPayments, 0, ',', '.') }}</h5>
            </div>
        </div>
    </div>
</div>
@endsection
