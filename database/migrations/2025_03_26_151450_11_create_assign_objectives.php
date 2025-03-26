<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('assign_objectives', function (Blueprint $table) {
            $table->id('ao_id');
            $table->unsignedBigInteger('o_id');
            $table->foreign('o_id')->references('o_id')->on('objectives')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('assign_objectives');
    }
};
