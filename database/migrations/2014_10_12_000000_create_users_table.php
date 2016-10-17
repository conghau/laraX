<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('last_name');
            $table->string('first_name');
            $table->tinyInteger('gender');
            $table->string('description');
            $table->dateTime('date_of_birth');
            $table->string('address');
            $table->string('avatar');
            $table->string('phone');
            $table->string('social_type');
            $table->string('social_id');
            $table->string('register_key');
            $table->string('login_token');
            $table->rememberToken();
            $table->timestamp('token_expired_at');
            $table->timestamp('last_login_at');
            $table->boolean('status')->default(TRUE);
            $table->timestamps();
            $table->text('meta');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
