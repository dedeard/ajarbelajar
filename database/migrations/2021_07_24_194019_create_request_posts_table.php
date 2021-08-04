<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_posts', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('minitutor_id')->unsigned();
            $table->foreign('minitutor_id')->references('id')->on('minitutors')->onDelete('cascade');

            $table->integer('category_id')->unsigned()->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');

            $table->string('hero')->unique()->nullable();
            $table->string('title');
            $table->longText('description')->nullable();

            $table->enum('type', ['article', 'video']);
            $table->longText('body')->nullable();

            $table->dateTime('requested_at')->nullable();
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
        Schema::dropIfExists('request_posts');
    }
}
