<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\TblMerchant;
use App\Models\TblMerchantPayment;

class TblMerchantPaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TblMerchantPayment::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'merchant_id' => TblMerchant::factory(),
            'order_id' => $this->faker->numberBetween(-100000, 100000),
            'amount' => $this->faker->randomFloat(0, 0, 9999999999.),
            'payment_date' => $this->faker->dateTime(),
        ];
    }
}
