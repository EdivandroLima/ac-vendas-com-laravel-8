<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VendaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'data' => $this->faker->unique()->dateTimeBetween('-11 months', 'now'),
            'valor_venda' => $this->faker->numberBetween(280, 500),
            'valor_projetado' => $this->faker->numberBetween(300, 300),
            'user_id' => 1
        ];
    }
}
