<?php

namespace Database\Seeders;

use App\Models\FluxoDeCaixa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FluxoDeCaixaSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FluxoDeCaixa::factory()->count(30)->create();
    }
}
