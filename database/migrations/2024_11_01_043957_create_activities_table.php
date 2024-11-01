<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_activities_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('day_id'); // Foreign key to days
            $table->string('title');
            $table->time('start_time');
            $table->time('end_time');
            $table->decimal('estimated_budget', 10, 2);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('day_id')->references('id')->on('days')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('activities');
    }
}
