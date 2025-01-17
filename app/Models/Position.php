<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Position extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // public function employees()
    // {
    //     return $this->hasMany(Employee::class);
    // }

        public function employees()
    {
        return $this->belongsToMany(Employee::class);
    }
}
