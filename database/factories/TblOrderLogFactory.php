<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\TblOrder;
use App\Models\TblOrderLog;

class TblOrderLogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TblOrderLog::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'order_id' => TblOrder::factory(),
            'status' => $this->faker->randomElement([""]),
            'message' => $this->faker->text(),
        ];
    }
}
