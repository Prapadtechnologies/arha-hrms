<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryCalculations extends Model
{
    use HasFactory;
    protected $table = 'salary_computation';
    protected $fillable = [
        'id',
        'created_by',
        'employee_id',
        'salary_data',
        'created_at',
        'updated_at'
    ];
}
