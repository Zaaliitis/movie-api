<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovieBroadcastsTable extends Migration
{
    public function up()
    {
        Schema::create('movie_broadcasts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('movie_id');
            $table->unsignedTinyInteger('channel_nr');
            $table->timestamp('broadcasts_at');
            $table->timestamps();

            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('movie_broadcasts');
    }
}
