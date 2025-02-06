<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('url')->nullable()->default(null);
            $table->string('mime')->nullable()->default(null);
            $table->text('title')->nullable()->default(null);
            $table->unsignedInteger('imageable_id')->nullable()->default(null);
            $table->string('imageable_type')->nullable()->default(null);
            $table->unsignedInteger('user_id')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
    }
}
