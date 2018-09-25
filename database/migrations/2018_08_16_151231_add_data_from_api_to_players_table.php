<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDataFromApiToPlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('players', function($table) {
            $table->integer('trophies')->default(0);
            $table->integer('max_trophies')->nullable();
            $table->integer('total_donation')->nullable();
            // $table->integer('clan_cards_collected')->nullable();
            $table->integer('tournament_cards_won')->nullable();
            $table->integer('challenge_max_wins')->nullable();
            $table->integer('challenge_cards_won')->nullable();
            $table->integer('level')->nullable();
            $table->integer('current_season_trophies')->nullable();
            $table->integer('current_season_best_trophies')->nullable();
            $table->integer('previous_season_trophies')->nullable();
            $table->integer('previous_season_best_trophies')->nullable();
            $table->string('best_season_id')->nullable();
            $table->integer('best_season_trophies')->nullable();
            $table->integer('total_games')->nullable();
            $table->integer('total_wins')->nullable();
            $table->integer('total_losses')->nullable();
            $table->integer('total_draws')->nullable();
            $table->integer('war_day_wins')->nullable();


       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('players', function($table) {
            $table->dropColumn('trophies');
            $table->dropColumn('max_trophies');
            $table->dropColumn('total_donation');
            // $table->dropColumn('clan_cards_collected');
            $table->dropColumn('tournament_cards_won');
            $table->dropColumn('challenge_max_wins');
            $table->dropColumn('challenge_cards_won');
            $table->dropColumn('level');
        });
    }
}
