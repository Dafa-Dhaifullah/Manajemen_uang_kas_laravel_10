@extends('layouts.app')

@section('content')
<div class="container-fluid py-5">
    <h1 class="h2 mb-4">Kelola Pengeluaran</h1>

    
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

    {{-- Form Tambah Pengeluaran Baru --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Tambah Pengeluaran Baru</h5>
            <form action="{{ route('expenses.store') }}" method="POST" class="row g-3">
                @csrf
                <div class="col-md-4">
                    <label for="amount" class="form-label">Jumlah</label>
                    <input type="number" class="form-control" name="amount" required>
                </div>
                <div class="col-md-4">
                    <label for="description" class="form-label">Deskripsi</label>
                    <input type="text" class="form-control" name="description" required>
                </div>
                <div class="col-md-3">
                    <label for="expense_date" class="form-label">Tanggal</label>
                    <input type="date" class="form-control" name="expense_date" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="col-md-1">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary d-block">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Daftar Pengeluaran --}}
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Daftar Pengeluaran</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($expenses as $expense)
                        <tr>
                            <td>{{ $expense->expense_date ? $expense->expense_date->format('Y-m-d') : '' }}</td>
                            <td>Rp {{ number_format($expense->amount, 0, ',', '.') }}</td>
                            <td>{{ $expense->description }}</td>
                            <td>
                                <button class="btn btn-sm btn-primary edit-expense" 
                                        data-id="{{ $expense->id }}"
                                        data-amount="{{ $expense->amount }}"
                                        data-description="{{ $expense->description }}"
                                        data-date="{{ $expense->expense_date ? $expense->expense_date->format('Y-m-d') : '' }}">
                                    Edit
                                </button>
                                <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin?')">Hapus</button>
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

{{-- Modal Edit Pengeluaran --}}
<div class="modal fade" id="editExpenseModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Pengeluaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editExpenseForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="edit_amount" class="form-label">Jumlah</label>
                        <input type="number" class="form-control" id="edit_amount" name="amount" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Deskripsi</label>
                        <input type="text" class="form-control" id="edit_description" name="description" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_expense_date" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="edit_expense_date" name="expense_date" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="editExpenseForm" class="btn btn-primary">Perbarui</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Event Handler untuk Menampilkan Modal Edit
    document.querySelectorAll('.edit-expense').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const amount = this.dataset.amount;
            const description = this.dataset.description;
            const date = this.dataset.date;
            
            document.getElementById('editExpenseForm').action = `/expenses/${id}`;
            document.getElementById('edit_amount').value = amount;
            document.getElementById('edit_description').value = description;
            document.getElementById('edit_expense_date').value = date;
            
            new bootstrap.Modal(document.getElementById('editExpenseModal')).show();
        });
    });
</script>
@endpush
