<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Employee extends Model implements JWTSubject
{
    use HasFactory;

    protected $fillable = [
        'name', 'username', 'password', 'unit_id', 'joined_at'
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
    public function positions()
    {
        return $this->belongsToMany(Position::class);
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


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
