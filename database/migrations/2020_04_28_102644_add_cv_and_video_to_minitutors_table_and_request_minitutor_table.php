<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCvAndVideoToMinitutorsTableAndRequestMinitutorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('minitutors', function (Blueprint $table) {
            $table->string('cv')->unique()->nullable();
        });
        Schema::table('request_minitutors', function (Blueprint $table) {
            $table->string('cv')->unique()->nullable();
            $table->string('video')->unique()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('minitutors', function (Blueprint $table) {
            $table->dropColumn('cv');
        });
        Schema::table('request_minitutors', function (Blueprint $table) {
            $table->dropColumn('cv');
            $table->dropColumn('video');
        });
    }
}
