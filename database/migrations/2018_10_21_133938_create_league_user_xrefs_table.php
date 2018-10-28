<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeagueUserXrefsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('league_user', function (Blueprint $table) {
            $table->integer('league_id');
            $table->integer('user_id');
            $table->enum('status', ['pending', 'accepted', 'declined']);
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
        Schema::drop('league_user', function (Blueprint $table) {
            //
        });
    }
}
