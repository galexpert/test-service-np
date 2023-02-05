<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations_lang', function (Blueprint $table) {
            $table->id();
            $table->string('title',255);
            $table->string('areadescription',300);
            $table->unsignedBigInteger('location_id');
            $table->char('lang', 7)->nullable(true);
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
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
        if(app()->isLocal()) {
            Schema::dropIfExists('realty_locations_lang');
        }
    }
};
