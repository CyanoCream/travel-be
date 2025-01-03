<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\TblNotification;

class TblNotificationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TblNotification::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(-100000, 100000),
            'user_type' => $this->faker->numberBetween(-100000, 100000),
            'message' => $this->faker->text(),
            'notification_type' => $this->faker->randomElement([""]),
            'is_read' => $this->faker->boolean(),
        ];
    }
}
