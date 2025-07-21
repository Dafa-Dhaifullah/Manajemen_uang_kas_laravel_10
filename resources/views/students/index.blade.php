@extends('layouts.app')

@section('content')
<div class="container-fluid py-5">
    <h1 class="h2 mb-4">Kelola Siswa</h1>
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Tambah Siswa Baru</h5>
            <form action="{{ route('students.store') }}" method="POST" class="row g-3">
                @csrf
                <div class="col-md-4">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="col-md-4">
                    <label for="student_id" class="form-label">NIS</label>
                    <input type="text" class="form-control" name="student_id" required>
                </div>
                <div class="col-md-3">
                    <label for="phone" class="form-label">No HP</label>
                    <input type="text" class="form-control" name="phone">
                </div>
                <div class="col-md-1">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary d-block">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Daftar Siswa</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>No HP</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                        <tr>
                            <td>{{ $student->student_id }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->phone }}</td>
                            <td>
                                <button class="btn btn-sm btn-primary edit-student" 
                                        data-id="{{ $student->id }}"
                                        data-name="{{ $student->name }}"
                                        data-student-id="{{ $student->student_id }}"
                                        data-phone="{{ $student->phone }}">
                                    Edit
                                </button>
                                <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline">
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

<!-- Edit Student Modal -->
<div class="modal fade" id="editStudentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editStudentForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_student_id" class="form-label">NIS</label>
                        <input type="text" class="form-control" id="edit_student_id" name="student_id" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_phone" class="form-label">No HP</label>
                        <input type="text" class="form-control" id="edit_phone" name="phone">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="editStudentForm" class="btn btn-primary">Perbarui</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.edit-student').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;
            const studentId = this.dataset.studentId;
            const phone = this.dataset.phone;
            
            document.getElementById('editStudentForm').action = `/students/${id}`;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_student_id').value = studentId;
            document.getElementById('edit_phone').value = phone;
            
            new bootstrap.Modal(document.getElementById('editStudentModal')).show();
        });
    });
</script>
@endpush
