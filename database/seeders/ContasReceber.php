<?php

namespace Database\Seeders;

use App\Models\ContasAReceber;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContasReceber extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContasAReceber::factory()->count(10)->create();
    }
}
