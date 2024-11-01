<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_days_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDaysTable extends Migration
{
    public function up()
    {
        Schema::create('days', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('itinerary_id'); // Assuming you have an itinerary table
            $table->integer('day'); // Day number
            $table->date('date'); // Date
            $table->timestamps();

            $table->foreign('itinerary_id')->references('id')->on('itineraries')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('days');
    }
}
