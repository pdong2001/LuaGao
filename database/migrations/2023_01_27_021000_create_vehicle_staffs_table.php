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
        Schema::create('vehicle_staffs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('staff_id');
            $table->unsignedBigInteger('vehicle_id');
            $table->foreign('staff_id')->references('id')->on('staffs')->onDelete('CASCADE');
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('CASCADE');
            $table->tinyInteger('type');
            $table->string('note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_staffs');
    }
};
