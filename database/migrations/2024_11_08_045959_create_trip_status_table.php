<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripStatusTable extends Migration
{
    public function up()
    {
        Schema::create('trip_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')->constrained()->onDelete('cascade'); // Link to trips table
            $table->enum('status', ['ongoing', 'pending', 'finished']); // Define possible statuses
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('trip_status');
    }
}
