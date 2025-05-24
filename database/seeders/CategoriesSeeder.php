<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoriesSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Actualités', 'slug' => 'actualites', 'description' => 'Actualités générales du parti'],
            ['name' => 'Communiqués', 'slug' => 'communiques', 'description' => 'Communiqués officiels du parti'],
            ['name' => 'Vie du parti', 'slug' => 'vie-du-parti', 'description' => 'Activités et événements du parti'],
            ['name' => 'Discours', 'slug' => 'discours', 'description' => 'Discours des membres du parti'],
            ['name' => 'Documents', 'slug' => 'documents', 'description' => 'Documents officiels du parti'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category['name'],
                'slug' => $category['slug'],
                'description' => $category['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
