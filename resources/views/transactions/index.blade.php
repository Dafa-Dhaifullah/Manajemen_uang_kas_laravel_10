<!-- resources/views/transactions/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <h1 class="h2 mb-4">Riwayat Transaksi</h1>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Tanggal & jam</th>
                            <th>Tipe</th>
                            <th>Jumlah</th>
                            <th>Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->transaction_date->format('Y-m-d H:i') }}</td>
                            <td>
                                <span class="badge bg-{{ $transaction->type == 'Pembayaran' ? 'success' : 'danger' }}">
                                    {{ ucfirst($transaction->type) }}
                                </span>
                            </td>
                            <td>Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                            <td>{{ $transaction->description }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">No transactions found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
</div>
@endsection