<?php

namespace Database\Factories;

use App\Models\ApiKey;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ApiKeyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ApiKey::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'public_key' => sprintf('PK_%s', Str::random(45)),
            'private_key' => sprintf('SK_%s', Str::random(45)),
            'active' => true,
            'user_id' => 1, // assume first user created it.
        ];
    }
}
