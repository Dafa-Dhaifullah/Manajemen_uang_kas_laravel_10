@extends('layouts.app')

@section('content')
<div class="container-fluid py-5">
    <h1 class="h2 mb-4">Kelola Uang Kas</h1>
    
    <!-- Tampilkan pesan sukses -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @elseif(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
  

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Tambah Periode Pembayaran</h5>
            <form action="{{ route('payments.store') }}" method="POST" class="row g-3">
                @csrf
                <div class="col-md-4">
                    <label for="month" class="form-label">Bulan</label>
                    <select class="form-select" name="month" required>
                        @foreach(range(1, 12) as $month)
                            <option value="{{ $month }}">{{ getMonthName($month) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="year" class="form-label">Tahun</label>
                    <input type="number" class="form-control" name="year" value="{{ date('Y') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary d-block">Tambah Periode</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Periode Pembayaran</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Periode</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($periods as $period)
                        <tr>
                            <td>{{ getMonthName($period->month) }} {{ $period->year }}</td>
                            <td>
                                <a href="{{ route('payments.show', $period) }}" class="btn btn-sm btn-primary">Kelola Pembayaran</a>
                                
                                <!-- Tombol Hapus -->
                                <form action="{{ route('payments.destroy', $period) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus periode ini? Semua pembayaran terkait akan ikut terhapus.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
