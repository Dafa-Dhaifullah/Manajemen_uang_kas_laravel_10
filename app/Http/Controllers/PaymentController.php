<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\PaymentPeriod;
use App\Models\Student;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Menampilkan semua periode pembayaran
    public function index()
    {
        $periods = PaymentPeriod::latest('year', 'month')->get();
        return view('payments.index', compact('periods'));
    }

    // Menampilkan form untuk membuat periode pembayaran baru
    public function create()
    {
        return view('payments.create');
    }

    // Menyimpan periode pembayaran baru
    public function store(Request $request)
{
    $validated = $request->validate([
        'month' => 'required|integer|between:1,12',
        'year' => 'required|integer|min:2000',
    ]);

    // Cek apakah periode sudah ada
    $existingPeriod = PaymentPeriod::where('month', $validated['month'])
                                   ->where('year', $validated['year'])
                                   ->first();

    if ($existingPeriod) {
        return redirect()->route('payments.index')
            ->with('error', 'Periode pembayaran ini sudah digunakan.');
    }

    // Simpan jika belum ada
    PaymentPeriod::create($validated);

    return redirect()->route('payments.index')
        ->with('success', 'Periode pembayaran berhasil ditambahkan.');
}


    // Menampilkan siswa dan pembayaran terkait periode tertentu
    public function show(PaymentPeriod $period)
    {
        $students = Student::with(['payments' => function ($query) use ($period) {
            $query->where('payment_period_id', $period->id);
        }])->get();

        return view('payments.show', compact('period', 'students'));
    }

    // Menyimpan pembayaran baru
    public function updatePayment(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'period_id' => 'required|exists:payment_periods,id',
            'week' => 'required|integer|between:1,4',
            'amount' => 'required|numeric|min:0',
        ]);

        Payment::create([
            'student_id' => $validated['student_id'],
            'payment_period_id' => $validated['period_id'],
            'week' => $validated['week'],
            'amount' => $validated['amount'],
            'payment_date' => now(),
        ]);

        return response()->json(['success' => true]);
    }
    
    // Hapus periode pembayaran tertentu
    public function destroy(PaymentPeriod $period)
    {
        $period->delete();

        return redirect()->route('payments.index')
                         ->with('success', 'Periode pembayaran berhasil dihapus.');
    }
}
