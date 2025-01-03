<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\TblMerchant;
use App\Models\TblProduct;
use App\Models\TblSalesReport;

class TblSalesReportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TblSalesReport::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'merchant_id' => TblMerchant::factory(),
            'product_id' => TblProduct::factory(),
            'total_sales' => $this->faker->randomFloat(0, 0, 9999999999.),
            'sales_quantity' => $this->faker->numberBetween(-100000, 100000),
            'report_month' => $this->faker->date(),
        ];
    }
}
