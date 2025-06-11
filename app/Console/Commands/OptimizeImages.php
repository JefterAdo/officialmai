<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Symfony\Component\Console\Helper\ProgressBar;

class OptimizeImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:optimize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimize existing images in the storage directory';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting image optimization...');

        // Setup Intervention Image Manager
        $manager = new ImageManager(new Driver());

        $files = Storage::disk('public')->allFiles();
        $imageFiles = array_filter($files, function ($file) {
            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            return in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
        });

        if (empty($imageFiles)) {
            $this->info('No images found to optimize.');
            return;
        }

        $progressBar = new ProgressBar($this->output, count($imageFiles));
        $progressBar->start();

        $optimizedCount = 0;
        $errorCount = 0;

        foreach ($imageFiles as $filePath) {
            try {
                $fullPath = Storage::disk('public')->path($filePath);
                $image = $manager->read($fullPath);
                $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

                // Optimize the image based on its type and save
                switch ($extension) {
                    case 'jpeg':
                    case 'jpg':
                        $image->toJpeg(75)->save($fullPath);
                        $optimizedCount++;
                        break;
                    case 'png':
                        // PNG optimization is lossless, but re-saving can sometimes help.
                        // For significant reduction, tools like pngquant would be needed.
                        $image->toPng()->save($fullPath);
                        $optimizedCount++;
                        break;
                    case 'gif':
                        $image->toGif()->save($fullPath);
                        $optimizedCount++;
                        break;
                    case 'webp':
                        $image->toWebp(75)->save($fullPath);
                        $optimizedCount++;
                        break;
                }
            } catch (\Exception $e) {
                $this->error("\nFailed to optimize {$filePath}: " . $e->getMessage());
                $errorCount++;
            }
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->info("\nOptimization complete.");
        $this->info("{$optimizedCount} images optimized successfully.");
        if ($errorCount > 0) {
            $this->warn("{$errorCount} images could not be optimized.");
        }
    }
}
