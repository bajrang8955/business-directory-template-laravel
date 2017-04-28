<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOpeningtimes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('openingtimes', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('listing_id');
            $table->string('weekday');
            $table->time('start');
            $table->time('end');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('openingtimes');
    }
}
