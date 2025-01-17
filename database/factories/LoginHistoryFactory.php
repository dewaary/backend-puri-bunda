<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\LoginHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LoginHistory>
 */
class LoginHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = LoginHistory::class;

    public function definition()
    {
        return [
            'employee_id' => Employee::inRandomOrder()->first()->id, 
            'login_time' => $this->faker->dateTimeThisYear(),
            'ip_address' => $this->faker->ipv4,
        ];
    }
}
