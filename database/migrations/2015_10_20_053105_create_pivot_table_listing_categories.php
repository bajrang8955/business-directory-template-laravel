<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePivotTableListingCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Schema::table('listings', function (Blueprint $table) {
            $table->dropColumn('categories');
        });*/

        Schema::create('listing_categories', function (Blueprint $table) {
            $table->integer('listing_id');
            $table->integer('category_id');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('listing_categories');

        /*Schema::table('listings', function (Blueprint $table) {
            $table->string('categories')->after('id')->nullable();
        });*/
        
    }
}
