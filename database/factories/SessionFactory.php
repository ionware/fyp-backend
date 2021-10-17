<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Session;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
            $departments = Department::pluck('id')->toArray();

            foreach ($departments as $departmentId) {
                $year = substr(explode('/', $session->year)[0], 2);
                $marker = strtoupper(substr(str_shuffle(Str::random(4)), 0, 2));

                for ($i = 1; $i < 8; $i++) {
                    // Create student account.
                    $session->students()->create(Student::factory()->make([
                        'matricNo' => sprintf('%s/47%s/%s', $year, $marker, str_pad($i, 3, STR_PAD_LEFT, '0')),
                        'department_id' => $departmentId,
                    ])->toArray());
                }
            }
        });
    }
}
