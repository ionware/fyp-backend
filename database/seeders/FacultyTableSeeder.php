<?php

namespace Database\Seeders;

use App\Models\Faculty;
use Illuminate\Database\Seeder;

class FacultyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faculties = [
            'Faculty of Agriculture' => [
                'Agricultural Economics',
                'Agricultural Extension',
                'Agronomy',
                'Animal Production',
                'Crop Production',
                'Horticulture & Landscaping',
            ],

            'Faculty of Education' => [
                'Business Education',
            ],

            'Faculty of Engineering and Technology' => [
                'Mechanical Engineering',
                'Civil Engineering',
                'Electrical & Electronic Engineering',
                'Agricultural & Biological Engineering',
                'Material Science & Engineering',
            ],

            'Faculty of Humanities, Management & Social Sciences' => [
                'Tourism & Hospitality Management',
                'Accounting',
                'Finance',
                'Business Administration',
                'Economics',
                'Public Administration',
            ],

            'Faculty of Information & Communication Technology' => [
                'Computer Science',
                'Mass Communication',
                'Library & Information Science',
            ],

            'Faculty of Pure & Applied Sciences' => [
                'Statistics',
                'Microbiology',
                'Biochemistry',
                'Industrial Chemistry',
                'Physics & Material Science',
                'Geology & Mineral Sciences',
            ],
        ];

        foreach ($faculties as $faculty => $departments) {
            $instance = Faculty::factory()->create(['name' => $faculty]);

            foreach ($departments as $department) {
                $instance->departments()->create(['name' => $department]);
            }
        }
    }
}
