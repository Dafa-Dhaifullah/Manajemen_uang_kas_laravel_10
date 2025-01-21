<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = ['type', 'amount', 'description', 'transaction_date', 'reference_id', 'reference_type'];

    protected $casts = [
        'transaction_date' => 'datetime',
    ];

}
