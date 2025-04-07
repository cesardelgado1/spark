<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('strategic_plans', function (Blueprint $table) {
            $table->id('sp_id');
            $table->string('sp_institution');
            $table->string('sp_years');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('strategic_plans');
    }
};
