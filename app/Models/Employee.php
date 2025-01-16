<?php

namespace App\Models;

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
}
