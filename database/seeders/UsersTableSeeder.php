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
                'title' => 'Dr. Mrs.',
                'firstName' => 'Folashade',
                'lastName' => 'Ajao',
            ],
            [
                'title' => 'Mr.',
                'firstName' => 'Akeem',
                'lastName' => 'Kadri',
                'email' => 'akeem.kadri@kwasu.edu.ng',
            ],
        ];

        foreach ($users as $user) {
            User::factory()->create($user);
        }

        User::factory()->create([
            'email' => 'adedeji.stephen@kwasu.edu.ng',
            'title' => 'Mr.',
            'firstName' => 'Adedeji',
            'lastName' => 'Stephen',
        ]);

        $class_rep = User::factory()->make(['email' => 'ionwarez@gmail.com', 'role' => 0])->toArray();
        User::create(array_merge($class_rep, [
            'allowed_departments' => '3,4,6',
            'password' => bcrypt('password'),
        ]));
    }
}
