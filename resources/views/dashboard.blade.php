@extends('layouts.app')

@section('content')
<div class="container-fluid py-5" >
    <h1 class="h2 mb-4">Dashboard</h1>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Uang Kas</h5>
                    <h2 class="card-text">Rp {{ number_format($currentBalance, 0, ',', '.') }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Pemasukan</h5>
                    <h2 class="card-text">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Pengeluaran</h5>
                    <h2 class="card-text">Rp {{ number_format($totalExpenses, 0, ',', '.') }}</h2>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
