<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_issues', function (Blueprint $table) {
            $table->id();
            $table->integer('server_id');
            $table->integer('drive_id');
            $table->integer('drive_asset_id');
            $table->integer('state_accet_id');
            $table->string('tmdb_url');
            $table->integer('tmdb_id')->nullable();
            $table->string('tmdb_media_type', 10)->default('none'); // none, movie, tv
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
        Schema::dropIfExists('media_issues');
    }
}
