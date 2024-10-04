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
        if (!Schema::hasTable('leaves')) {
            Schema::create('leaves', function (Blueprint $table) {
                $table->id();
                $table->string('date')->nullable();
                $table->string('year')->nullable();
                $table->foreignId('user_id')->default(0);
                $table->string('type')->nullable();
                $table->string('reason')->nullable();
                $table->string('lead_status')->default('pending');
                $table->string('hr_status')->default('pending');
                $table->string('final_status')->default('pending');
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
        Schema::dropIfExists('leaves');
    }
};
