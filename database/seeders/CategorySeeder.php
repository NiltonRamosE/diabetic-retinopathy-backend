<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Crear 5 categorías aleatorias
        Category::factory()->count(5)->create();
    }
}
