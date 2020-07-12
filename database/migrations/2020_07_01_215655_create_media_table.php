<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->integer('drive_id');
            $table->integer('drive_asset_id');
            $table->integer('state_asset_id');
            $table->integer('tmdb_id');
            $table->string('media_title');
            $table->string('slug');
            $table->integer('release_year');
            $table->string('vote_average',4)->nullable();
            $table->string('poster_92_path')->default('/static/img/noposter_92.jpg');
            $table->string('poster_154_path')->default('/static/img/noposter_154.jpg');
            $table->string('media_type', 10);
            $table->text('overview')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media');
    }
}
