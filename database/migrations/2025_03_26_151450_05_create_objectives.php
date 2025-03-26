<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('objectives', function (Blueprint $table) {
            $table->id('o_id');
            $table->integer('o_num');
            $table->text('o_text');
            $table->unsignedBigInteger('g_id')->index();
            $table->foreign('g_id')->references('g_id')->on('goals')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('objectives');
    }
};
