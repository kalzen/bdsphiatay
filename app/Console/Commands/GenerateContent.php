<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Tag;
use DB;
use Log;

class GenerateContent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:content';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    const DOMAIN = 'https://hondamotor.vn/';
    public function handle()
    {
        try {
            include(storage_path('app/simple_html_dom.php'));
            // DB::table('tags')->truncate();
            // DB::table('taggables')->truncate();
            $products = Product::latest()->get();
            foreach($products as $product) {
                $body = file_get_html(self::DOMAIN . $product->slug.'.html');
                $product->update([
                    'description'=>($body->find('.content-descr',0)->plaintext??$product->description),
                    'content'=>trim($body->find('.content-special',0)->innertext??$product->content)
                ]);
                if (1) {//!$product->tags()->count()
                    $tags = array_filter(explode(',',$body->find('meta[name="keywords"]',0)->content));
                    $tags_ = [];
                    foreach($tags as $tag) {
                        $tags_[] = Tag::updateOrCreate(['name'=>trim($tag)])->id;
                    }
                    $product->tags()->syncWithoutDetaching($tags_);
                }

            }
        } catch(Exception $ex) {
            $this->error($ex->getMessage());
        }
            
        
        return 0;
    }
}
