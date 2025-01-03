<?php

namespace Database\Factories\Master;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CoachFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "user_id" => 0,
            "code" => "C".rand(1000, 9999),
            "first_name" => $this->faker->firstName(),
            "last_name" => $this->faker->lastName(),
            "certification_level" => "KKNI Level 4",
            "specialization" => "Trainer",
            "status" => "ACTIVE",
            "gender" => rand(0, 1),
        ];
    }
}
