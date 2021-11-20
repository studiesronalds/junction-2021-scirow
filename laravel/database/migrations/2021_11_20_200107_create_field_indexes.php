<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldIndexes extends Migration
{
    /**
     * Run the migrations.
     *


     * @return void
     */
    public function up()
    {
        Schema::table('index_average', function (Blueprint $table) {
            $table->index(['apartment_id', 'type']);
        });

        Schema::table('index_max', function (Blueprint $table) {
            $table->index(['apartment_id', 'type']);
        });

        Schema::table('index_min', function (Blueprint $table) {
            $table->index(['apartment_id', 'type']);
        });

        Schema::table('index_most_times', function (Blueprint $table) {
            $table->index(['apartment_id', 'type']);
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
