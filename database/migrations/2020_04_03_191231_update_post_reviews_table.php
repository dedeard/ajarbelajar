<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePostReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('post_reviews', function (Blueprint $table) {
            $table->dropColumn('rating');
            $table->dropColumn('body');
            $table->boolean('sync_with_me')->default(false);
            $table->integer('understand')->default(1)->unsigned();
            $table->integer('inspiring')->default(1)->unsigned();
            $table->integer('language_style')->default(1)->unsigned();
            $table->integer('content_flow')->default(1)->unsigned();
            $table->text('message')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('post_reviews', function (Blueprint $table) {
            $table->integer('rating')->unsigned();
            $table->text('body')->nullable();
            $table->dropColumn('sync_with_me');
            $table->dropColumn('understand');
            $table->dropColumn('inspiring');
            $table->dropColumn('language_style');
            $table->dropColumn('content_flow');
            $table->dropColumn('message');
        });
    }
}
