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
            $table->string('tripTitle');
            $table->string('tripDestination');
            $table->date('tripStartDate');
            $table->date('tripEndDate');
            $table->decimal('totalBudget', 10, 2);
            $table->string('currency', 3);
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('trips');
    }
}
