<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOmbiRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ombi_requests', function (Blueprint $table) {
            $table->id();
            $table->string('ombi_userid');
            $table->string('media_type', 20);
            $table->string('title');
            $table->timestamp('release_date');
            $table->text('json_data');
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
        Schema::dropIfExists('ombi_requests');
    }
}
