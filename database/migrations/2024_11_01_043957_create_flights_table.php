<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_flights_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlightsTable extends Migration
{
    public function up()
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('day_id'); // Foreign key to days
            $table->string('flight_number');
            $table->date('date');
            $table->time('departure_time');
            $table->time('arrival_time');
            $table->decimal('cost', 10, 2);
            $table->timestamps();

            $table->foreign('day_id')->references('id')->on('days')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('flights');
    }
}
