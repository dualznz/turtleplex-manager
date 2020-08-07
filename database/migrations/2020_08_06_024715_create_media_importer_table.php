<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaImporterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_importer', function (Blueprint $table) {
            $table->id();
            $table->string('hash_id');
            $table->integer('server_id');
            $table->integer('drive_id');
            $table->integer('drive_asset_id');
            $table->string('media_title');
            $table->string('tmdb_media_type');
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
        Schema::dropIfExists('media_importer');
    }
}
