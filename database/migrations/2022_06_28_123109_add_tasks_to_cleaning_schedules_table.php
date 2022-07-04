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
        Schema::table('cleaning_schedules', function (Blueprint $table) {
            $table->boolean('isDishes')->default(0);
            $table->boolean('isTrash')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cleaning_schedules', function (Blueprint $table) {
            $table->dropColumn('isDishes');
            $table->dropColumn('isTrash');
        });
    }
};
