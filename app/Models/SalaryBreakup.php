<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryBreakup extends Model
{
    use HasFactory;
    protected $table = 'salary_breakups';
    protected $fillable = [
        'id',
        'created_by',
        'component_name',
        'component_type',
        'component_value_type',
        'created_at',
        'updated_at'
    ];
}
