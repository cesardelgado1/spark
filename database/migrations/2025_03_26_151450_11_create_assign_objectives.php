<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('assign_objectives', function (Blueprint $table) {
            $table->id('ao_id');

            $table->unsignedBigInteger('ao_ObjToFill');
            $table->foreign('ao_ObjToFill')->references('o_id')->on('objectives')->onDelete('cascade');

            $table->unsignedBigInteger('ao_assigned_to');
            $table->foreign('ao_assigned_to')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('ao_assigned_by');
            $table->foreign('ao_assigned_by')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('assign_objectives');
    }
};

