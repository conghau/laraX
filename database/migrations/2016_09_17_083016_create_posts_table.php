<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('post_author_id')->unsigned()
                ->index()
                ->references('id')
                ->on('users');
            $table->timestamp('post_date_gmt');
            $table->longText('post_content');
            $table->string('post_title', 500);
            $table->string('post_slug',500);
            $table->string('post_excerpt', 500);
            $table->boolean('comment_status')->default(1)->index();
            $table->boolean('ping_status')->default(1);
            $table->string('post_name', 200);
            $table->text('post_content_filtered');
            $table->integer('menu_order');
            $table->string('post_type', 10)->default('post')->index();
            $table->integer('comment_count')->default(0);
            $table->string('guid')->index();
            $table->tinyInteger('post_status')->default(1);
            $table->boolean('is_popular')->default(0);
            $table->timestamps();
            $table->text('meta');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('posts');
    }
}
