<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoginHistory extends Model
{
    use HasFactory;

    protected $table = 'login_histories';

    protected $fillable = [
        'employee_id',
        'login_time',
        'ip_address',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
