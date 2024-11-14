<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToFriendsTable extends Migration
{
    public function up()
    {
        Schema::table('friends', function (Blueprint $table) {
            $table->string('status')->default('pending'); // Add the status column
        });
    }

    public function down()
    {
        Schema::table('friends', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
