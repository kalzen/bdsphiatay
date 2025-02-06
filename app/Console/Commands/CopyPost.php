<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Models\Post;
use App\Models\Product;
use App\Models\Category;
use App\Models\Catalogue;
use Carbon\Carbon;
use Log;

class CopyPost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'post:copy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copy posts';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        foreach(DB::table('wsk_term_taxonomy')->where('taxonomy','category')->get() as $item) {
            $info = DB::table('wsk_terms')->where('term_id', $item->term_id)->first();
            if ($info) {
                Category::updateOrCreate([
                    'id' => $item->term_id,
                ],[
                    'name' => $info->name,
                    'slug' => $info->slug,
                ]);
            }
        }
        foreach(DB::table('wsk_term_taxonomy')->where('taxonomy','product_cat')->get() as $item) {
            $info = DB::table('wsk_terms')->where('term_id', $item->term_id)->first();
            if ($info) {
                Catalogue::updateOrCreate([
                    'id' => $item->term_id,
                ],[
                    'name' => $info->name,
                    'slug' => $info->slug,
                    'description' => $item->description,
                ]);
            }
        }
        foreach(DB::table('wsk_posts')->where('post_type','post')->get() as $post) {
            $created = Post::updateOrCreate([
                'id'=> $post->ID,
            ],[
                'title' => $post->post_title,
                'slug' => $post->post_name,
                'description' => $post->post_excerpt,
                'content' => $post->post_content,
                'user_id' => $post->post_author,
                'status' => $post->post_status === 'publish' ? Post::STATUS_ACTIVE : Post::STATUS_INACTIVE,
                'created_at' => $post->post_date,
                'updated_at' => $post->post_modified,
            ]);
            foreach(DB::table('wsk_term_relationships')->where('object_id',$post->ID)->get() as $item) {
                $term = DB::table('wsk_term_taxonomy')->where('term_taxonomy_id', $item->term_taxonomy_id)->first();
                if ($term && $term->taxonomy === 'category') {
                    $term = DB::table('wsk_terms')->where('term_id', $term->term_id)->first();
                    if ($term) {
                        $created->categories()->syncWithoutDetaching([$term->term_id]);
                    }
                }
            }
            foreach(DB::table('wsk_posts')->where('post_type','attachment')->where('post_parent',$post->ID)->get() as $item) {
                $coms = collect(explode('/',$item->guid));
                $coms->shift(3);
                $coms->prepend('userfiles/files');
                $created->images()->updateOrCreate([
                    'images.id' => $item->ID,
                ],[
                    'url' => $item->guid ? ('/'.$coms->join('/')) : '',
                    'title' => $item->post_title,
                    'mime' => $item->post_mime_type,
                    'user_id' => $item->post_author,
                    'created_at' => $item->post_date,
                    'updated_at' => $item->post_modified,
                ]);
            }
            foreach(DB::table('wsk_comments')->where('comment_post_ID',$post->ID)->get() as $item) {
                $created->comments()->updateOrCreate([
                    'comments.id' => $item->comment_ID,
                ],[
                    'body' => $item->comment_content,
                    'ip' => $item->comment_author_IP,
                    'agent' => $item->comment_agent,
                    'author' => $item->comment_author,
                    'email' => $item->comment_author_email,
                    'url' => $item->comment_author_url,
                    'created_at' => $item->comment_date,
                ]);
            }
        }
        foreach(DB::table('wsk_posts')->where('post_type','product')->get() as $post) {
            $price = DB::table('wsk_postmeta')->where('post_id', $post->ID)->where('meta_key','_price')->first();
            $regular_price = DB::table('wsk_postmeta')->where('post_id', $post->ID)->where('meta_key','_regular_price')->first();
            $created = Product::updateOrCreate([
                'id'=> $post->ID,
            ],[
                'title' => $post->post_title,
                'slug' => $post->post_name,
                'description' => $post->post_excerpt,
                'content' => $post->post_content,
                'user_id' => $post->post_author,
                'status' => $post->post_status === 'publish' ? Product::STATUS_ACTIVE : Product::STATUS_INACTIVE,
                'created_at' => $post->post_date,
                'updated_at' => $post->post_modified,
                'price' => $price->meta_value ?? 0,
                'regular_price' => $regular_price->meta_value ?? 0,
            ]);
            foreach(DB::table('wsk_term_relationships')->where('object_id',$post->ID)->get() as $item) {
                $term = DB::table('wsk_term_taxonomy')->where('term_taxonomy_id', $item->term_taxonomy_id)->first();
                if ($term && $term->taxonomy === 'product_cat') {
                    $term = DB::table('wsk_terms')->where('term_id', $term->term_id)->first();
                    if ($term) {
                        $created->catalogues()->syncWithoutDetaching([$term->term_id]);
                    }
                }
            }
            foreach(DB::table('wsk_posts')->where('post_type','attachment')->where('post_parent',$post->ID)->get() as $item) {
                $coms = collect(explode('/',$item->guid));
                $coms->shift(3);
                $coms->prepend('userfiles/files');
                $created->images()->updateOrCreate([
                    'images.id' => $item->ID,
                ],[
                    'url' => $item->guid ? ('/'.$coms->join('/')) : '',
                    'title' => $item->post_title,
                    'mime' => $item->post_mime_type,
                    'user_id' => $item->post_author,
                    'created_at' => $item->post_date,
                    'updated_at' => $item->post_modified,
                ]);
            }
            foreach(DB::table('wsk_comments')->where('comment_post_ID',$post->ID)->get() as $item) {
                $created->comments()->updateOrCreate([
                    'comments.id' => $item->comment_ID,
                ],[
                    'body' => $item->comment_content,
                    'ip' => $item->comment_author_IP,
                    'agent' => $item->comment_agent,
                    'author' => $item->comment_author,
                    'email' => $item->comment_author_email,
                    'url' => $item->comment_author_url,
                    'created_at' => $item->comment_date,
                ]);
            }
        }
        return 0;
    }
}
