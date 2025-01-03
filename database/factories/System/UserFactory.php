<?php

namespace Database\Factories\System;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "name" => $this->faker->name(),
            "email" => $this->faker->unique()->firstName()."@mail.com",
            "phone_number" => str_replace([" ", "(", ")"], "", $this->faker->phoneNumber()),
            "password" => Hash::make('123')
        ];
    }
}
