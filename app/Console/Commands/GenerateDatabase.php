<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;
use DB;
use App\Models\Product;
use App\Models\Image;
use App\Models\Catalogue;
use App\Models\User;

class GenerateDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:database';

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

    const SOURCE_DOMAIN = 'https://motor-html.stockware.ru/';
    public function handle()
    {
        $user = User::first();
        try {
            $json = json_decode(file_get_contents(base_path('public/frontend/json/home.json')),true);
            $user = User::first();
            // DB::table('products')->truncate();
            // DB::table('catalogues')->truncate();
            // DB::table('images')->truncate();
            // DB::table('image_product')->truncate();
            // DB::table('catalogue_product')->truncate();
            foreach($json as $key=>$item) {
                $catalogue = Catalogue::updateOrCreate([
                    'slug' => trim($item['category']['slug'],'/')
                ],[
                    'name' => $item['category']['name'],
                ]);
                if ($key < 7) {
                    if (!$catalogue->image) {
                        $catalogue->image()->create([
                            'url'=>self::SOURCE_DOMAIN.'img/front-categories/frcateg'.($key+1).'.png',
                            'user_id' => $user->id
                        ]);
                    } 
                }
                foreach($item['category']['children'] as $child) {
                    $product = Product::updateOrCreate([
                        'slug' => trim($child['slug'],'/'),
                    ],[
                        'title' => $child['name'],
                        'price' => floatval($child['price']??0),
                        'user_id' => $user->id
                    ]);
                    if (!$product->catalogues()->count()) {
                        $product->catalogues()->syncWithoutDetaching([$catalogue->id]);
                    }
                    if (!$product->images()->count()) {
                        $image = Image::updateOrCreate([
                            'url' => $child['image']
                        ],[
                            'user_id' => $user->id
                        ]);
                        $product->images()->syncWithoutDetaching([$image->id]);
                    }
                }
            }
        } catch(Exception $ex) {
            $this->error($ex->getMessage());
        }
            
        
        return 0;
    }
}
