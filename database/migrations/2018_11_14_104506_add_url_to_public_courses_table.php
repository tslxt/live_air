<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUrlToPublicCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('public_courses', function (Blueprint $table) {
            $table->string('image')->nullable()->after('title');
            $table->string('courseware')->nullable()->after('image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('public_courses', function (Blueprint $table) {
             $table->drop_column('image'); 
             $table->drop_column('courseware'); 
        });
    }
}
