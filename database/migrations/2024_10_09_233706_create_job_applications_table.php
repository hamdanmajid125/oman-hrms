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
        if (!Schema::hasTable('job_applications')) {
            Schema::create('job_applications', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->string('email')->nullable();
                $table->foreignId('job_id')->default(0);
                $table->string('phone')->nullable();
                $table->string('date_of_birth')->nullable();
                $table->string('gender')->nullable();
                $table->string('profile')->nullable();
                $table->string('resume')->nullable();
                $table->longText('cover_letter')->nullable();
                $table->string('company')->nullable();
                $table->string('job')->nullable();
                $table->string('weakness')->nullable();
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
        Schema::dropIfExists('job_applications');
    }
};