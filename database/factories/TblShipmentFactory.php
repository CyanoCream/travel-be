<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\TblOrder;
use App\Models\TblShipment;

class TblShipmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TblShipment::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'order_id' => TblOrder::factory(),
            'shipping_address' => $this->faker->text(),
            'shipping_status' => $this->faker->randomElement([""]),
            'tracking_number' => $this->faker->word(),
            'shipped_at' => $this->faker->dateTime(),
        ];
    }
}
