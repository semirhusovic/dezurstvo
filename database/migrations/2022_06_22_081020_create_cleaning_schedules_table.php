<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cleaning_schedules', function (Blueprint $table) {
            $table->id();
            $table->date("monitoringDate");
            $table->foreignId('user1_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('user2_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cleaning_schedules');
    }
};
