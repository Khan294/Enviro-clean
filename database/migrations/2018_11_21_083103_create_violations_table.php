<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViolationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('violations', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('image')->default('img/noPicture.png');
            $table->string('unitNumber');

            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedInteger('infraction_id');
            $table->foreign('infraction_id')->references('id')->on('infractions')->onUpdate('cascade')->onDelete('cascade');
            
            $table->unsignedInteger('fence_id');
            $table->foreign('fence_id')->references('id')->on('fences')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('violations');
    }
}
