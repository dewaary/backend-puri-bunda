<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Position;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Employee::class;

    public function definition()
    {
        $positionIds = Position::inRandomOrder()->limit(rand(1, 3))->pluck('id');

        return [
            'name' => $this->faker->name,
            'username' => $this->faker->unique()->userName,
            'password' => bcrypt('password'),
            'unit_id' => Unit::inRandomOrder()->first()->id,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Employee $employee) {
            $positionIds = Position::inRandomOrder()->limit(rand(1, 3))->pluck('id');
            $employee->positions()->attach($positionIds);
        });
    }
}
