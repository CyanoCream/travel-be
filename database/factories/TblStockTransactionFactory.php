<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\TblMerchant;
use App\Models\TblProduct;
use App\Models\TblStockTransaction;

class TblStockTransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TblStockTransaction::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'product_id' => TblProduct::factory(),
            'merchant_id' => TblMerchant::factory(),
            'transaction_type' => $this->faker->randomElement([""]),
            'quantity' => $this->faker->numberBetween(-10000, 10000),
            'transaction_date' => $this->faker->dateTime(),
        ];
    }
}
