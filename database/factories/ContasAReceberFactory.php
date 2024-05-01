<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\ContasAReceber;
use Illuminate\Database\Eloquent\Factories\Factory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ContasAReceberFactory extends Factory
{
    public function withFaker()
    {
        return \Faker\Factory::create('pt_BR');
    }
    protected $model = ContasAReceber::class;

    public function definition()
    {
        return [
            'cliente_id' => Cliente::factory(), // Cria um novo Cliente automaticamente ou referencia um existente
            'descricao' => $this->faker->sentence(), // Gera uma frase aleatória
            'valor' => $this->faker->randomFloat(2, 100, 5000), // Gera um valor entre 100 e 5000 com 2 casas decimais
            'data_vencimento' => $this->faker->date(), // Gera uma data aleatória
            'data_recebimento' => $this->faker->optional()->date(), // Gera uma data opcional
            'status' => $this->faker->randomElement(['recebido', 'pendente', 'atrasado']), // Escolhe um estado aleatório
        ];
    }
}
