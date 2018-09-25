<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTournamentBattlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tournament_battles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tournament_id');
            $table->integer('field_id');
            $table->integer('player1_id')->nullable();
            $table->integer('player2_id')->nullable();
            $table->integer('p1_score')->nullable();
            $table->integer('p2_score')->nullable();
            $table->integer('winner_id')->nullable();

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
        Schema::dropIfExists('tournament_battles');
    }
}
