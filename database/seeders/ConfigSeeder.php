<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Config;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Config::create(['name'=>'address','value'=>'']);
        Config::create(['name'=>'logo','value'=>'']);
        Config::create(['name'=>'email','value'=>'']);
        Config::create(['name'=>'hotline','value'=>'']);
    }
}
