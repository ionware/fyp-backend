<?php

namespace Database\Factories;

use App\Models\Session;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class SessionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Session::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'year' => '2014/2015'
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function($session) {
            $year = substr(explode('/', $session->year)[0], 2);
            $limit = mt_rand(20, 45);

            for ($i = 1; $i < $limit; $i++) {
                // Create student account.
                $session->students()->create(Student::factory()->make([
                    'matricNo' => sprintf('%s/47CS/%s', $year, str_pad($i, 3, STR_PAD_LEFT, '0')),
                ])->toArray());
            }
        });
    }
}
