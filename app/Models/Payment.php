<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['student_id', 'payment_period_id', 'week', 'amount', 'payment_date'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function paymentPeriod()
    {
        return $this->belongsTo(PaymentPeriod::class);
    }
}
