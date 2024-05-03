<?php

namespace Database\Factories;

use App\Models\FluxoDeCaixa;
use App\Models\PlanoDeContas;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FluxoDeCaixa>
 */
class FluxoDeCaixaFactory extends Factory
{

    public function withFaker()
    {
        return \Faker\Factory::create('pt_BR');
    }
    protected $model = FluxoDeCaixa::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'plano_contas_id' => $this->faker->numberBetween(1,182),
            'descricao' => $this->faker->sentence(),
            'valor' => $this->faker->randomFloat(2, 10, 500),
            'data_transacao' => $this->faker->date(),
            'tipo' => $this->faker->randomElement(['entrada', 'saida'])

        ];
    }
}
