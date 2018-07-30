<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDetailFieldsToActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activities', function ($table) {
            $table->longText('value_from');
            $table->longText('value_to');
            $table->integer('loggable_id');
            $table->string('loggable_type');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activities', function ($table) {
            $table->dropColumn('value_from');
            $table->dropColumn('value_to');
            $table->dropColumn('loggable_id');
            $table->dropColumn('loggable_type');
        });
    }
}
