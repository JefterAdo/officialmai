<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class SlidesSeeder extends Seeder
{
    public function run(): void
    {
        try {
            $slidesPath = storage_path('app/public/slides');
            Log::info("Checking slides path: " . $slidesPath);
            
            if (!File::exists($slidesPath)) {
                Log::error("Slides directory does not exist: " . $slidesPath);
                return;
            }

            $files = File::files($slidesPath);
            Log::info("Found " . count($files) . " files");

            foreach ($files as $file) {
                $filename = $file->getFilename();
                Log::info("Processing file: " . $filename);
                
                try {
                    DB::table('slides')->insert([
                        'title' => 'Slide ' . $filename,
                        'description' => 'Description du slide',
                        'image_path' => 'slides/' . $filename,
                        'order' => 0,
                        'is_active' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    Log::info("Inserted slide: " . $filename);
                } catch (\Exception $e) {
                    Log::error("Error inserting slide: " . $filename . " - " . $e->getMessage());
                }
            }
        } catch (\Exception $e) {
            Log::error("Error in SlidesSeeder: " . $e->getMessage());
        }
    }
} 