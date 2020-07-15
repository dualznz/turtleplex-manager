<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMediaIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('media_issues', function (Blueprint $table) {
            $table->dropColumn('state_accent_id');
            $table->integer('state_asset_id')->after('drive_asset_id');
            $table->integer('completed')->default(0)->after('tmdb_media_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('media_issues', function (Blueprint $table) {
            $table->dropColumn('state_asset_id');
            $table->integer('state_accent_id')->after('drive_asset_id');
            $table->dropColumn('completed');
        });
    }
}
