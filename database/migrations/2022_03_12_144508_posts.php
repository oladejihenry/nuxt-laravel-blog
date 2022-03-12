<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->index();
            $table->string('title');
            $table->string('slug');
            $table->text('body');
            $table->text('excerpt')->nullable();
            $table->string('image')->nullable();
            $table->string('featured_image')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('categories_posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('post_id')->index();
            $table->foreignId('category_id')->index();
            
            $table->unique(['post_id', 'category_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
