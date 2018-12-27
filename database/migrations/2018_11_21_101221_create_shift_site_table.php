<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShiftSiteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shift_site', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            
            $table->unsignedInteger('shift_id');
            $table->foreign('shift_id')->references('id')->on('shifts')->onUpdate('cascade')->onDelete('cascade');

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
        Schema::table('shift_site', function (Blueprint $table) {
            //
        });
    }
}
