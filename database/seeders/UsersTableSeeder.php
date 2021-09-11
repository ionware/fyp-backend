<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'title' => 'Dr. Mrs.',
                'firstName' => 'Ronke',
                'lastName' => 'Babatunde',
            ],
            [
                'title' => 'Dr.',
                'firstName' => 'Isiaka',
                'lastName' => 'Isiaka',
            ],
            [
                'title' => 'Mr.',
                'firstName' => 'Abdulsalam',
                'lastName' => 'Abdulsalam',
            ],
            [
                'title' => 'Dr.',
                'firstName' => 'Babatunde',
                'lastName' => 'Babatunde',
            ],
            [
                'title' => 'Dr. Mrs.',
                'firstName' => 'Folashade',
                'lastName' => 'Ajao',
            ],
        ];

        foreach ($users as $user) {
            User::factory()->create($user);
        }
    }
}
