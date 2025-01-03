<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\TblCartItem;
use App\Models\TblProduct;

class TblCartItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TblCartItem::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'cart_id' => $this->faker->numberBetween(-100000, 100000),
            'product_id' => TblProduct::factory(),
            'quantity' => $this->faker->numberBetween(-100000, 100000),
            'price' => $this->faker->numberBetween(-100000, 100000),
            'total_price' => $this->faker->numberBetween(-100000, 100000),
        ];
    }
}
