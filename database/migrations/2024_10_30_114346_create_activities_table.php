<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Activity Title
            $table->time('start_time'); // Start Time
            $table->time('end_time'); // End Time
            $table->decimal('estimated_budget', 10, 2); // Estimated Budget
            $table->text('description')->nullable(); // Description
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('activities');
    }
}
