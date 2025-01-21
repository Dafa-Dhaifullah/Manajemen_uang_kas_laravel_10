<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Expense;

class DashboardController extends Controller
{
    public function index()
    {
        $totalIncome = Payment::sum('amount');
        $totalExpenses = Expense::sum('amount');
        $currentBalance = $totalIncome - $totalExpenses;

        return view('dashboard', compact('totalIncome', 'totalExpenses', 'currentBalance'));
    }
}