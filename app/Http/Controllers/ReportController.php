<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;  
use App\Models\Payment;
use App\Models\Expense;
use App\Models\PaymentPeriod;
use App\Models\Student;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $periods = PaymentPeriod::orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();
        return view('reports.index', compact('periods'));
    }

    public function paymentReport(Request $request)
    {
        $period = PaymentPeriod::findOrFail($request->period_id);
        
        $students = Student::with(['payments' => function($query) use ($period) {
            $query->where('payment_period_id', $period->id);
        }])->get();

        $totalPayments = Payment::where('payment_period_id', $period->id)->sum('amount');

        if ($request->has('export_pdf')) {
            $pdf = PDF::loadView('reports.payments_pdf', compact('period', 'students', 'totalPayments'));
            return $pdf->download('payment_report_' . $period->month . '_' . $period->year . '.pdf');
        }

        return view('reports.payments', compact('period', 'students', 'totalPayments'));
    }

    public function expenseReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        $expenses = Expense::whereBetween('expense_date', [
            $request->start_date,
            $request->end_date
        ])->orderBy('expense_date')->get();

        $totalExpenses = $expenses->sum('amount');

        if ($request->has('export_pdf')) {
            $pdf = PDF::loadView('reports.expenses_pdf', compact('expenses', 'totalExpenses', 'request'));
            return $pdf->download('expense_report_' . $request->start_date . '_to_' . $request->end_date . '.pdf');
        }

        return view('reports.expenses', compact('expenses', 'totalExpenses', 'request'));
    }
}