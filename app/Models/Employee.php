<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'username', 'password', 'unit_id', 'position_id', 'joined_at'
    ];

    protected $hidden = [
        'password',
    ];

    // Relasi dengan Unit
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    // Relasi dengan Position
    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($employee) {
            // Jika 'joined_at' tidak ada dalam data, set menjadi waktu sekarang
            if (!$employee->joined_at) {
                $employee->joined_at = Carbon::now(); // Gunakan waktu sekarang
            }
        });
    }
}
