<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Post;
use App\Models\Image;
use App\Models\Tag;
use App\Models\Category;

class GenerateNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:news';

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
            $user = User::first();
            $json = json_decode(file_get_contents(base_path('public/frontend/json/news.json')),true);
            $category = Category::updateOrCreate([
                'slug' => 'tin-bao-chi',
            ],[
                'name' => 'Tin báo chí',
            ]);
            foreach($json as $item) {
                $body = file_get_html(self::DOMAIN . trim($item['slug'],'/').'.html');
                $post = Post::updateOrCreate([
                    'slug' => trim($item['slug'],'/'),
                ],[
                    'title' => $item['name'],
                    'user_id' => $user->id,
                    'content' => str_replace('src="/uploads','src="'.self::DOMAIN.'uploads',$body->find('.page-inner',0)->innertext),
                    'description' => $item['desc']
                ]);
                if (!$post->categories()->count()) {
                    $post->categories()->syncWithoutDetaching([$category->id]);
                }
                if (!$post->tags()->count()) {
                    $tags = array_filter(explode(',',$body->find('meta[name="keywords"]',0)->content));
                    $tags_ = [];
                    foreach($tags as $tag) {
                        $tags_[] = Tag::updateOrCreate(['name'=>trim($tag)])->id;
                    }
                    $post->tags()->syncWithoutDetaching($tags_);
                }
                if (!$post->images()->count()) {
                    $image = Image::updateOrCreate([
                        'url' => self::DOMAIN . str_replace('..','',$item['image'])
                    ],[
                        'user_id' => $user->id,
                    ]);
                    $post->images()->syncWithoutDetaching([$image->id]);
                }
            }
        }catch(Exception $ex) {
            $this->error($ex->getMessage());
        }
        return 0;
    }
}
