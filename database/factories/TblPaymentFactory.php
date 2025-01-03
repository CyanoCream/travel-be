<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\TblOrder;
use App\Models\TblPayment;

class TblPaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TblPayment::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'order_id' => TblOrder::factory(),
            'payment_method' => $this->faker->randomElement([""]),
            'amount' => $this->faker->randomFloat(0, 0, 9999999999.),
            'payment_status' => $this->faker->numberBetween(-100000, 100000),
            'payment_date' => $this->faker->numberBetween(-100000, 100000),
        ];
    }
}
