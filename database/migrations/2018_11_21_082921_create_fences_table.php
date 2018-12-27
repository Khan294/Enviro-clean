<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fences', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('fenceName')->unique();
            $table->string('address');
            $table->decimal('lng', 11, 8);
            $table->decimal('lat', 11, 8);
            $table->decimal('rad', 6, 2);

            $table->unsignedInteger('site_id');
            $table->foreign('site_id')->references('id')->on('sites')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fences');
    }
}
