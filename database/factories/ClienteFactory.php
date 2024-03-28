<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     *
     */

     public function withFaker()
    {
        return \Faker\Factory::create('pt_BR');
    }

     public function definition(): array
    {
        return [
            'nome_fantasia' => $this->faker->company,
            'razao_social' => $this->faker->company,
            'cpf_cnpj' => $this->faker->unique()->cnpj,
            'ie' => $this->faker->optional()->randomNumber(6),
            'situacao' => $this->faker->randomElement(['Ativo', 'Inativo']),
            'vencimento' => $this->faker->dateTimeThisYear('+1 year'),
            'rua' => $this->faker->streetName,
            'bairro' => $this->faker->secondaryAddress,
            'cidade' => $this->faker->city,
            'estado' => $this->faker->stateAbbr,
            'cep' => $this->faker->postcode,
        ];
    }
}
