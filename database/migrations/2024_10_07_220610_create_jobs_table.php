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
        if (!Schema::hasTable('jobs')) {
            Schema::create('jobs', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('job_title')->nullable();
                $table->string('branch')->nullable;
                $table->string('shift_id')->nullable();
                $table->string('no_of_position')->nullable();
                $table->tinyInteger('status')->default(0);
                $table->string('start_date')->nullable();
                $table->string('end_date')->nullable();
                $table->string('skills')->nullable();
                $table->longText('description')->nullable();
                $table->longText('requirement')->nullable();
                $table->string('depart_id')->nullable();
                $table->timestamps();
            });
        }    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
};
