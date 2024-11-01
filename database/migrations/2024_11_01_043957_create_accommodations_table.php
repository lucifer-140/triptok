<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_accommodations_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccommodationsTable extends Migration
{
    public function up()
    {
        Schema::create('accommodations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('day_id'); // Foreign key to days
            $table->string('name');
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->decimal('cost', 10, 2);
            $table->timestamps();

            $table->foreign('day_id')->references('id')->on('days')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('accommodations');
    }
}
