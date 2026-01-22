<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate {--url= : Optional base URL to generate sitemap for}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sitemap.xml using Spatie\Sitemap\SitemapGenerator';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $url = $this->option('url') ?: config('app.url');

        if (empty($url)) {
            $this->error('No base URL found. Set APP_URL in .env or pass --url option.');
            return 1;
        }

        $this->info("Generating sitemap for: {$url}");

        try {
            SitemapGenerator::create($url)
                ->writeToFile(public_path('sitemap.xml'));

            $this->info('Sitemap written to ' . public_path('sitemap.xml'));
            return 0;
        } catch (\Exception $e) {
            $this->error('Failed to generate sitemap: ' . $e->getMessage());
            return 1;
        }
    }
}
