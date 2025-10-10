<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PubCategory;

class PubCategorySeeder extends Seeder
{
    public function run(): void
    {
        PubCategory::create(['name' => 'Tech', 'description' => 'Articles sur la technologie']);
        PubCategory::create(['name' => 'News', 'description' => 'Dernières actualités']);
        PubCategory::create(['name' => 'Political', 'description' => 'Articles politiques']);
    }
}
