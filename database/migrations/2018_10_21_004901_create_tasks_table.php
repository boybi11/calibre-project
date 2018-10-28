<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments("id")->unsigned();
            $table->integer("league_id");
            $table->string("title");
            $table->string("slug");
            $table->text("description");
            $table->decimal("duration", 10, 2);
            $table->decimal("exp", 10, 2);
            $table->integer("points");
            $table->enum("status", ['pending', 'active', 'completed']);
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
        Schema::drop('tasks', function (Blueprint $table) {
            //
        });
    }
}
