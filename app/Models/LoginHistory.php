<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoginHistory extends Model
{
    use HasFactory;

    protected $table = 'login_histories'; // Nama tabel di database

    // Tentukan kolom-kolom yang bisa diisi
    protected $fillable = [
        'employee_id',
        'login_time',
        'ip_address',
    ];

    // Relasi dengan tabel Employee
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
