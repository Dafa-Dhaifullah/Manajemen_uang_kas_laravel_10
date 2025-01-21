<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Payment; // Asumsi ada model untuk pemasukan
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::orderBy('expense_date', 'desc')->get();
        return view('expenses.index', compact('expenses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string',
            'expense_date' => 'required|date'
        ]);

        // Hitung saldo kas saat ini
        $currentBalance = $this->getCashBalance();

        // Validasi jika pengeluaran melebihi saldo kas
        if ($validated['amount'] > $currentBalance) {
            return redirect()->route('expenses.index')
                ->with('error', 'Gagal menambahkan pengeluaran! Saldo kas tidak mencukupi.');
        }

        // Simpan pengeluaran jika saldo mencukupi
        Expense::create($validated);

        return redirect()->route('expenses.index')
            ->with('success', 'Pengeluaran berhasil ditambahkan');
    }

    public function update(Request $request, Expense $expense)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string',
            'expense_date' => 'required|date'
        ]);

        $currentBalance = $this->getCashBalance() + $expense->amount; // Tambahkan kembali nilai sebelumnya

        if ($validated['amount'] > $currentBalance) {
            return redirect()->route('expenses.index')
                ->with('error', 'Gagal memperbarui pengeluaran! Saldo kas tidak mencukupi.');
        }

        $expense->update($validated);
        
        return redirect()->route('expenses.index')
            ->with('success', 'Pengeluaran berhasil diperbarui');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        
        return redirect()->route('expenses.index')
            ->with('success', 'Pengeluaran berhasil dihapus');
    }

    // Fungsi untuk menghitung saldo kas
    private function getCashBalance()
    {
        $totalIncome = Payment::sum('amount'); // Asumsi model Income ada
        $totalExpense = Expense::sum('amount');

        return $totalIncome - $totalExpense;
    }
}
