<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItinerariesTable extends Migration
{
    public function up()
    {
        Schema::create('itineraries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')->constrained()->onDelete('cascade'); // Foreign key to trips table
            $table->date('trip_day');
            $table->string('activity_title')->nullable();
            $table->time('activity_start_time')->nullable();
            $table->time('activity_end_time')->nullable();
            $table->decimal('activity_budget', 10, 2)->nullable();
            $table->string('activity_description', 500)->nullable();
            $table->string('transport_title')->nullable();
            $table->time('transport_start_time')->nullable();
            $table->time('transport_end_time')->nullable();
            $table->decimal('transport_budget', 10, 2)->nullable();
            $table->string('accommodation_name')->nullable();
            $table->date('accommodation_checkin')->nullable();
            $table->date('accommodation_checkout')->nullable();
            $table->decimal('accommodation_budget', 10, 2)->nullable();
            $table->string('flight_number')->nullable();
            $table->time('flight_departure')->nullable();
            $table->time('flight_arrival')->nullable();
            $table->decimal('flight_cost', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('itineraries');
    }
}
