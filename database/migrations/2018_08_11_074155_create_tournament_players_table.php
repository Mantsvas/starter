<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTournamentPlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tournament_players', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tournament_id')->unsigned();
            $table->integer('player_id')->unsigned();
            $table->integer('starting_position')->nullable();
            $table->timestamps();
            // $table->foreign('tournament_id')->references('id')->on('tournaments');
            // $table->foreign('player_id')->references('id')->on('players');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tournament_players');
    }
}
