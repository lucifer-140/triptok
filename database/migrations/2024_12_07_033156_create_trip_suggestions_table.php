<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripSuggestionsTable extends Migration
{
    public function up()
    {
        Schema::create('trip_suggestions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trip_id');
            $table->string('country');
            $table->date('trip_start_date');
            $table->date('trip_end_date');
            $table->integer('day');
            $table->date('date');
            $table->unsignedBigInteger('activity_id');
            $table->string('activity_title');
            $table->time('activity_start_time');
            $table->time('activity_end_time');
            $table->decimal('activity_budget', 10, 2);
            $table->string('activity_description');
            $table->string('transport_type')->nullable();
            $table->time('transport_departure_time')->nullable();
            $table->time('transport_arrival_time')->nullable();
            $table->decimal('transport_cost', 10, 2)->nullable();
            $table->string('accommodation_name');
            $table->date('accommodation_check_in');
            $table->date('accommodation_check_out');
            $table->decimal('accommodation_cost', 10, 2);
            $table->timestamps(); // created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('trip_suggestions');
    }
}
