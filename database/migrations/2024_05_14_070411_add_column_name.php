<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('shortcuts', function ($table) {
            $table->string('nama');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('shortcuts', function ($table) {
            $table->dropColumn('nama');
        });
    }
};
