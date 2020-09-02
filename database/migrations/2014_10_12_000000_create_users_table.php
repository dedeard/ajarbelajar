<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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

            $table->string('name');
            $table->string('avatar')->unique()->nullable();
            $table->integer('points')->default(0);

            $table->string('about')->nullable()->default(null);
            $table->string('website_url')->nullable()->default(null);

            $table->string('twitter_url')->nullable()->default(null);
            $table->string('facebook_url')->nullable()->default(null);
            $table->string('instagram_url')->nullable()->default(null);
            $table->string('youtube_url')->nullable()->default(null);

            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
