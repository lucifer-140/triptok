<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusAndNewTripToSharedTripsTable extends Migration
{
    public function up()
    {
        Schema::table('shared_trips', function (Blueprint $table) {
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->unsignedBigInteger('new_trip')->nullable(); // This will hold the ID of the duplicated trip
        });
    }

    public function down()
    {
        Schema::table('shared_trips', function (Blueprint $table) {
            $table->dropColumn(['status', 'new_trip']);
        });
    }
}
