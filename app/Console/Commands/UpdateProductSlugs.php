<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class UpdateProductSlugs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:update-slugs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update missing slugs for all products';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Updating missing product slugs...');
        
        $updatedCount = Product::updateMissingSlugs();
        
        $this->info("Updated {$updatedCount} products with missing slugs.");
        
        return 0;
    }
}
