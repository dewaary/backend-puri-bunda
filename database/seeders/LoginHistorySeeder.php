<?php

namespace Database\Seeders;

use App\Models\LoginHistory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LoginHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        LoginHistory::factory(500)->create();
    }
}
