<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripsTable extends Migration
{
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('trip_title', 100);
            $table->string('destination', 100);
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('total_budget', 10, 2);
            $table->string('currency', 3);
            $table->integer('total_days'); // Add total_days column
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('trips');
    }
}
