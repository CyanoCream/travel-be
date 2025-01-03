<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\TblMerchant;

class TblMerchantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TblMerchant::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'display_picture' => $this->faker->word(),
            'city_id' => $this->faker->numberBetween(-100000, 100000),
            'address' => $this->faker->numberBetween(-100000, 100000),
            'contact_person' => $this->faker->numberBetween(-100000, 100000),
            'status' => $this->faker->boolean(),
        ];
    }
}
