<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('assign_indicators', function (Blueprint $table) {
            $table->id('ai_id');
            $table->unsignedBigInteger('i_id');
            $table->foreign('i_id')->references('i_id')->on('indicators')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('assign_indicators');
    }
};
