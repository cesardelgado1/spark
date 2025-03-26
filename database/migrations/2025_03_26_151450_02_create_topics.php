<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('topics', function (Blueprint $table) {
            $table->id('t_id');
            $table->integer('t_num');
            $table->text('t_text');
            $table->unsignedBigInteger('sp_id')->index();
            $table->foreign('sp_id')->references('sp_id')->on('strategic_plans')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('topics');
    }
};
