<?php

namespace Database\Factories;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "data_time" => now(),
            "sum" => $this->faker->randomFloat(10, 20, 60),
            "doc" => $this->faker->opera(),
            'shop_id' => Shop::query()->inRandomOrder()->value('id')
        ];
    }
}
