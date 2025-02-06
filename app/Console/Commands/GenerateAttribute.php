<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Attribute;

class GenerateAttribute extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:attribute';

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

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Attribute::insert(collect(['Động cơ','Dung tích xi lanh','Đường kính x hành trình piston','Tỷ lệ nén','Công suất cực đại','Mô-men xoắn cực đại'])
        ->map(function($item){
            return ['name'=>$item];
        })->all());
        return 0;
    }
}
