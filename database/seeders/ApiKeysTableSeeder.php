<?php

namespace Database\Seeders;

use App\Models\ApiKey;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class ApiKeysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ApiKey::factory()
            ->count(14)
            ->state(new Sequence(['active' => true], ['active' => false]))
            ->create();
    }
}
