@extends('layouts.app')

@section('content')
<div class="container-fluid py-5">
    <h1 class="h2 mb-4">Status Pembayaran - {{ getMonthName($period->month) }} {{ $period->year }}</h1>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Id siswa</th>
                            <th>Nama</th>
                            <th>minggu 1</th>
                            <th>minggu 2</th>
                            <th>minggu 3</th>
                            <th>minggu 4</th>
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
                                <td>
                                    @if($payment)
                                        <span class="badge bg-success">sudah bayar</span>
                                    @else
                                        <button class="btn btn-sm btn-outline-primary update-payment" 
                                                data-student-id="{{ $student->id }}"
                                                data-period-id="{{ $period->id }}"
                                                data-week="{{ $week }}">
                                            Bayar
                                        </button>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="paymentForm">
                    <input type="hidden" name="student_id" id="student_id">
                    <input type="hidden" name="period_id" id="period_id">
                    <input type="hidden" name="week" id="week">
                    <div class="mb-3">
                        <label for="amount" class="form-label">Nominal</label>
                        <input type="number" class="form-control" id="amount" name="amount" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="confirmPayment">Konfirmasi</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.update-payment').forEach(button => {
        button.addEventListener('click', function() {
            const studentId = this.dataset.studentId;
            const periodId = this.dataset.periodId;
            const week = this.dataset.week;
            
            document.getElementById('student_id').value = studentId;
            document.getElementById('period_id').value = periodId;
            document.getElementById('week').value = week;
            
            new bootstrap.Modal(document.getElementById('paymentModal')).show();
        });
    });

    document.getElementById('confirmPayment').addEventListener('click', function() {
        const formData = new FormData(document.getElementById('paymentForm'));
        
        fetch('{{ route("payments.update") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(Object.fromEntries(formData))
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    });
</script>
@endpush
