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

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function positions()
    {
        return $this->belongsToMany(Position::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($employee) {
            if (!$employee->joined_at) {
                $employee->joined_at = Carbon::now();
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
