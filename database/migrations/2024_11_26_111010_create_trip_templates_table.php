<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_templates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('destination_id'); // Foreign key to destinations
            $table->string('name');
            $table->text('description');
            $table->integer('duration'); // in days
            $table->decimal('price', 10, 2); // Optional pricing info
            $table->timestamps();

            $table->foreign('destination_id')->references('id')->on('destinations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trip_templates');
    }
}
