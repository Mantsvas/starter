<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id');
            $table->string('title');
            $table->text('body');
            $table->string('cover_image');
            $table->string('card1');
            $table->string('card2');
            $table->string('card3');
            $table->string('card4');
            $table->string('card5');
            $table->string('card6');
            $table->string('card7');
            $table->string('card8');
            $table->string('youtube_url');
            $table->integer('card_guide1');
            $table->text('card_guide_body1');
            $table->integer('card_guide2');
            $table->text('card_guide_body2');
            $table->integer('card_guide3');
            $table->text('card_guide_body3');
            $table->integer('card_guide4');
            $table->text('card_guide_body4');
            $table->text('early');
            $table->text('late');
            $table->string('source')->nullable();
            $table->integer('views')->default(0);
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
        Schema::dropIfExists('posts');
    }
}
