<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\TblProduct;
use App\Models\TblProductCategory;

class TblProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TblProduct::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'product_name' => $this->faker->numberBetween(-100000, 100000),
            'merchant_id' => $this->faker->numberBetween(-100000, 100000),
            'type' => $this->faker->numberBetween(-100000, 100000),
            'price' => $this->faker->randomFloat(0, 0, 9999999999.),
            'stock' => $this->faker->numberBetween(-100000, 100000),
            'category_id' => TblProductCategory::factory(),
            'description' => $this->faker->text(),
            'status' => $this->faker->boolean(),
        ];
    }
}
