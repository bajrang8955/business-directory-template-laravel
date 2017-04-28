<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WmakeColsNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('listings', function($table)
        {
            $table->string('title')->nullable()->change();
            $table->string('slug')->nullable()->change();
            $table->string('description')->nullable()->change();
            $table->string('phone')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('address')->nullable()->change();
            $table->string('latitude')->nullable()->change();
            $table->string('longitude')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('listings', function($table)
        {
            $table->string('title')->change();
            $table->string('slug')->change();
            $table->string('description')->change();
            $table->string('phone')->change();
            $table->string('email')->change();
            $table->string('address')->change();
            $table->string('latitude')->change();
            $table->string('longitude')->change();
        });
    }
}
