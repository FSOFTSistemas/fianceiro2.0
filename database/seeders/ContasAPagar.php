<?php

namespace Database\Seeders;

use App\Models\ContasAPagar as ModelsContasAPagar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContasAPagar extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModelsContasAPagar::factory()->count(10)->create();
    }
}
