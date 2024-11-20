<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCheckOutTimeToAccommodationsTable extends Migration
{
    public function up()
    {
        // Adding the 'check_out_time' column to the 'accommodations' table
        Schema::table('accommodations', function (Blueprint $table) {
            $table->time('check_out_time'); // Add the check_out_time column of type time
        });
    }

    public function down()
    {
        // Rolling back the migration by dropping the 'check_out_time' column
        Schema::table('accommodations', function (Blueprint $table) {
            $table->dropColumn('check_out_time');
        });
    }
}
