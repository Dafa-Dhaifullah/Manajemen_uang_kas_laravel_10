<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::orderBy('name')->get();
        return view('students.index', compact('students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'student_id' => 'required|string|unique:students',
            'phone' => 'nullable|string'
        ]);

        Student::create($validated);
        return redirect()->route('students.index')
                         ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'student_id' => 'required|string|unique:students,student_id,' . $student->id,
            'phone' => 'nullable|string'
        ]);

        $student->update($validated);
        return redirect()->route('students.index')
                         ->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')
                         ->with('success', 'Data siswa berhasil dihapus.');
    }
}
