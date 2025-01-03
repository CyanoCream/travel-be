<?php

namespace Database\Factories\Master;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ManagementFactory extends Factory
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
            "code" => "M".rand(1000, 9999),
            "name" => $this->faker->company(),
            "contact_person" => $this->faker->name(),
            "contact_email" => $this->faker->unique()->firstName()."@mail.com",
            "contact_phone" => str_replace([" ", "(", ")"], "", $this->faker->phoneNumber()),
            "address" => $this->faker->address(),
            "status" => "ACTIVE",
            "category_id" => 1,
        ];
    }
}
