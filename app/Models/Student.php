<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'student_id', 'phone'];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
