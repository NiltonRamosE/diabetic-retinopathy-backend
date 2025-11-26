<?php

namespace Database\Seeders;

use App\Models\Image;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    public function run(): void
    {
        // Crear 20 imágenes aleatorias asociadas a doctores y categorías
        Image::factory()->count(20)->create();
    }
}
