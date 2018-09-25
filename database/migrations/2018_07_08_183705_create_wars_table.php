<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wars', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('place');
            $table->integer('wins');
            $table->integer('crowns');
            $table->integer('trophies');
            $table->integer('participiants');
            $table->integer('max_battles');
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
        Schema::dropIfExists('wars');
    }
}
