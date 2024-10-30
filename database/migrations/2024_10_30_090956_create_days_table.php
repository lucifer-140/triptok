<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDaysTable extends Migration
{
    public function up()
    {
        Schema::create('days', function (Blueprint $table) {
            $table->id();
            $table->foreignId('itinerary_id')->constrained()->onDelete('cascade');
            $table->integer('day'); // Day number in the itinerary
            $table->date('date'); // Specific date for the day
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('days');
    }
}
