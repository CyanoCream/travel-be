<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\TblProduct;
use App\Models\TblProductPicture;

class TblProductPictureFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TblProductPicture::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'product_id' => TblProduct::factory(),
            'picture' => $this->faker->numberBetween(-100000, 100000),
        ];
    }
}
