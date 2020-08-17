<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMinitutorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('minitutors', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned()->unique();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->boolean('active')->default(false);

            $table->string('last_education')->nullable();
            $table->string('university')->nullable();
            $table->string('city_and_country_of_study')->nullable();
            $table->string('majors')->nullable();
            $table->string('interest_talent')->nullable();
            $table->string('contact')->nullable();
            $table->string('reason')->nullable();
            $table->string('expectation')->nullable();
            $table->string('cv')->unique()->nullable();

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
        Schema::dropIfExists('minitutors');
    }
}
