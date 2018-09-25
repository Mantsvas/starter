<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTournamentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tournaments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('champion_id')->unsigned()->nullable();
            $table->integer('2nd_place_id')->unsigned()->nullable();
            $table->integer('3rd_place_id')->unsigned()->nullable();
            $table->integer('status')->default(0); // 0 - registration open,  1 - tournament has started,  2 - tournament is finished

            $table->timestamps();
            // $table->foreign('champion_id')->references('id')->on('players');
            // $table->foreign('2nd_place_id')->references('id')->on('players');
            // $table->foreign('3rd_place_id')->references('id')->on('players');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tournaments');
    }
}
