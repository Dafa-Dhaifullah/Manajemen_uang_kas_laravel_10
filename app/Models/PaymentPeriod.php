<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentPeriod extends Model
{
    protected $fillable = ['month', 'year'];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
