<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('goals', function (Blueprint $table) {
            $table->id('g_id');
            $table->integer('g_num');
            $table->text('g_text');
            $table->unsignedBigInteger('t_id')->index();
            $table->foreign('t_id')->references('t_id')->on('topics')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('goals');
    }
};
