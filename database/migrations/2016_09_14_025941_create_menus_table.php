<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::dropIfExists('menus');
    Schema::dropIfExists('menu_contents');
    Schema::dropIfExists('menu_nodes');

    Schema::create('menus', function ($table) {
      $table->increments('id')->unsigned();
      $table->string('name', 120);
      $table->string('slug', 120)->unique()->nullable();
      $table->boolean('status')->default(1);
      $table->softDeletes();
      $table->timestamps();
    });
    Schema::create('menu_contents', function ($table) {
      $table->increments('id')->unsigned();
      $table->integer('menu_id')
        ->unsigned()
        ->index()
        ->references('id')
        ->on('menus');
      $table->timestamps();
    });
    Schema::create('menu_nodes', function ($table) {
      $table->increments('id')->unsigned();
      $table->integer('menu_content_id')
        ->unsigned()
        ->index()
        ->references('id')
        ->on('menu_contents');
      $table->integer('parent_id')->default(0)->unsigned()->index();
      $table->integer('related_id')->default(0)->unsigned()->index();
      $table->string('type', 60);
      $table->string('url', 120)->nullable();
      $table->string('icon_font', 50)->nullable();
      $table->tinyinteger('position')->unsigned()->default(0);
      $table->string('title', 120)->nullable();
      $table->string('css_class', 120)->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::drop('menus');
    Schema::drop('menu_contents');
    Schema::drop('menu_nodes');
  }
}
