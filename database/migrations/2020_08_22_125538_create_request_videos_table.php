<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_videos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('request_playlist_id')->unsigned();
            $table->foreign('request_playlist_id')->references('id')->on('request_playlists')->onDelete('cascade');
            $table->string('name')->unique();
            $table->integer('index');
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
        Schema::dropIfExists('request_videos');
    }
}
