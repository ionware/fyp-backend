<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'surname' => $this->faker->firstName,
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'gender' => $this->faker->randomElement(['M', 'F']),
            'email' => $this->faker->email,
            'matricNo' => '17/67AA/163',
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
            'session_id' => 1,  // assume first session.
            'department_id' => 1,   // assume first department.
        ];
    }
}
