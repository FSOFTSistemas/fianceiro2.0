<?php

namespace Database\Factories;

use App\Models\ContasAPagar;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContasAPagar>
 */
class ContasAPagarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     public function withFaker()
     {
         return \Faker\Factory::create('pt_BR');
     }
     protected $model = ContasAPagar::class;
    public function definition(): array
    {
        return [
            'fornecedor' => $this->faker->company,
            'descricao' => $this->faker->sentence,
            'valor' => $this->faker->randomFloat(2, 100, 1000),
            'data_vencimento' => $this->faker->date(),
            'data_pagamento' => $this->faker->randomElement([null, $this->faker->date()]),
            'status' => $this->faker->randomElement(['pendente', 'pago', 'atrasado']),
        ];
    }
}
