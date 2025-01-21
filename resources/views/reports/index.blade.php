@extends('layouts.app')

@section('content')
<div class="container-fluid py-5">
    <h1 class="h2 mb-4">Laporan</h1>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Laporan Pembayaran</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('reports.payments') }}" method="GET" target="_self">
                        <div class="mb-3">
                            <label for="period_id" class="form-label">Pilih periode</label>
                            <select class="form-select" name="period_id" required>
                                @foreach($periods as $period)
                                    <option value="{{ $period->id }}">
                                    {{ getMonthName($period->month) }} {{ $period->year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Buat laporan</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Laporan Pengeluaran</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('reports.expenses') }}" method="GET" target="_self">
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Tanggal Awal</label>
                            <input type="date" class="form-control" name="start_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="end_date" class="form-label">Tanggal Akhir</label>
                            <input type="date" class="form-control" name="end_date" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Buat Laporan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
