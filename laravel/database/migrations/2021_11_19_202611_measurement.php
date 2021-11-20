<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Measurement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('measurement', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type', 255)->nullable();
            $table->integer('apartment_id');
            $table->integer('consumption');
            $table->string('temp');
            $table->string('flow_time');
            $table->string('power_consumption', 255)->nullable();
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
        //
    }
}
