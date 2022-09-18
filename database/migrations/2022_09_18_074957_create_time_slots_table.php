<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_slots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('schedule_id')->nullable();
            $table->unsignedBigInteger('employee_id');
            $table->string('employee_name');
            $table->date('date')->index();
            $table->time('start_time')->index();
            $table->time('end_time')->index();
            $table->unsignedTinyInteger('state')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('time_slots');
    }
};
