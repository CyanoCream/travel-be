<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\TblOrder;

class TblOrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TblOrder::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'customer_id' => $this->faker->numberBetween(-100000, 100000),
            'total_amount' => $this->faker->randomFloat(0, 0, 9999999999.),
            'status' => $this->faker->randomElement([""]),
        ];
    }
}
