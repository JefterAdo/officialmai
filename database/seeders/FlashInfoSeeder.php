<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FlashInfo;

class FlashInfoSeeder extends Seeder
{
    public function run(): void
    {
        FlashInfo::factory()->count(5)->create();
    }
}
