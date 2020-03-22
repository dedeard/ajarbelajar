<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('title')->default('Ajarbelajar');
            $table->text('description')->default('AjarBelajar diisi oleh konten dari MiniTutor dengan berbagai macam latar belakang. Ada banyak bidang ilmu dan topik bahasan yang bisa disimak.');
            $table->string('keywords')->default('ajarbelajar,ajarbelajar.com,minitutor,artikel,videos,belajar,berbagi,berkontribusi');
            $table->string('robots')->default('index,follow');
            $table->string('distribution')->default('web');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seos');
    }
}
